<?php

namespace BezhanSalleh\PanelSwitch;

use Closure;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Support\Components\Component;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Arr;
use League\Uri\Uri;

class PanelSwitch extends Component
{
    use Concerns\HasPanelValidator;

    protected array | Closure $excludes = [];

    protected bool | Closure | null $visible = null;

    protected bool | Closure | null $canSwitchPanel = true;

    protected bool | Closure $isModalSlideOver = false;

    protected string | Closure | null $modalWidth = null;

    protected bool | Closure $isSimple = false;

    protected array | Closure $icons = [];

    protected int | Closure | null $iconSize = null;

    protected array | Closure $labels = [];

    protected array | Closure | null $panels = null;

    protected bool $renderIconAsImage = false;

    protected string | Closure $modalHeading = 'Switch Panels';

    protected string $renderHook = 'panels::global-search.before';

    protected ?string $sortOrder = null;

    public static function make(): static
    {
        $static = app(static::class);

        $static->visible(function () use ($static) {
            if (($user = auth()->user()) === null) {
                return false;
            }

            if (method_exists($user, 'canAccessPanel')) {
                return $user->canAccessPanel($static->getCurrentPanel());
            }

            return true;
        });

        $static->configure();

        if (count($static->getPanels()) < 2) {
            $static->visible(false);
        }

        return $static;
    }

    public static function boot(): void
    {
        $static = static::make();

        FilamentView::registerRenderHook(
            name: $static->getRenderHook(),
            hook: function () use ($static) {

                if (! $static->isVisible()) {
                    return '';
                }

                return view('filament-panel-switch::panel-switch-menu', [
                    'currentPanel' => $static->getCurrentPanel(),
                    'heading' => $static->getModalHeading(),
                    'icons' => $static->getIcons(),
                    'iconSize' => $static->getIconSize(),
                    'isSimple' => $static->isSimple(),
                    'isSlideOver' => $static->isModalSlideOver(),
                    'labels' => $static->getLabels(),
                    'modalWidth' => $static->getModalWidth(),
                    'panels' => $static->getPanels(),
                    'renderIconAsImage' => $static->getRenderIconAsImage(),
                ]);
            },
        );
    }

    public function canSwitchPanels(bool | Closure $condition): static
    {
        $this->canSwitchPanel = $condition;

        return $this;
    }

    /**
     * @deprecated Use `panels()` instead.
     */
    public function excludes(array | Closure $panelIds): static
    {
        $this->excludes = $panelIds;

        return $this;
    }

    public function modalHeading(string | Closure $modalHeading): static
    {
        $this->modalHeading = $modalHeading;

        return $this;
    }

    public function icons(array | Closure $icons, bool $asImage = false): static
    {
        if ($asImage) {
            foreach ($icons as $key => $icon) {
                if (! str($icon)->startsWith(['http://', 'https://'])) {
                    throw new \Exception('All icons must be URLs when $asImage is true.');
                }
            }
        }

        $this->renderIconAsImage = $asImage;

        $this->icons = $icons;

        return $this;
    }

    public function iconSize(int | Closure | null $size = null): static
    {
        $this->iconSize = $size;

        return $this;
    }

    public function labels(array | Closure $labels): static
    {
        $this->labels = $labels;

        return $this;
    }

    public function modalWidth(string | Closure | null $width = null): static
    {
        $this->modalWidth = $width;

        return $this;
    }

    public function panels(array | Closure | null $panels = null): static
    {
        $this->panels = $panels;

        return $this;
    }

    public function renderHook(string $hook): static
    {
        $this->renderHook = $hook;

        return $this;
    }

    public function slideOver(bool | Closure $condition = true): static
    {
        $this->isModalSlideOver = $condition;

        return $this;
    }

    public function simple(bool | Closure $condition = true): static
    {
        $this->isSimple = $condition;

        return $this;
    }

    /**
     * Whether to sort the panels by their order or not.
     * 1. null - Default order, provided by the user through the `panels` method.
     * 2. 'asc' - Ascending order
     * 3. 'desc' - Descending order
     */
    public function sort(string $order = 'asc'): static
    {
        $this->sortOrder = $order;

        return $this;
    }

    public function visible(bool | Closure $visible): static
    {
        $this->visible = $visible;

        return $this;
    }

    public function getExcludes(): array
    {
        return (array) $this->evaluate($this->excludes);
    }

    public function getModalHeading(): string
    {
        return (string) $this->evaluate($this->modalHeading);
    }

    public function getIcons(): array
    {
        return (array) $this->evaluate($this->icons);
    }

    public function getIconSize(): int
    {
        return $this->evaluate($this->iconSize) ?? 32;
    }

    public function getLabels(): array
    {
        return (array) $this->evaluate($this->labels);
    }

    public function getModalWidth(): string
    {
        return $this->evaluate($this->modalWidth) ?? 'screen';
    }

    public function isAbleToSwitchPanels(): bool
    {
        if (($user = auth()->user()) === null) {
            return false;
        }

        if (method_exists($user, 'canSwitchPanels')) {
            return $user->canSwitchPanels();
        }

        return $this->evaluate($this->canSwitchPanel);
    }

    public function isModalSlideOver(): bool
    {
        return (bool) $this->evaluate($this->isModalSlideOver);
    }

    public function isSimple(): bool
    {
        return (bool) $this->evaluate($this->isSimple);
    }

    public function isVisible(): bool
    {
        return (bool) $this->evaluate($this->visible);
    }

    public function getSortOrder(): ?string
    {
        return $this->evaluate($this->sortOrder);
    }

    public function getPanels(): array
    {
        $panelIds = (array) $this->evaluate($this->panels);

        return collect(Filament::getPanels())
            ->reject(fn (Panel $panel) => in_array($panel->getId(), $this->getExcludes()))
            ->when(
                value: filled($panelIds),
                callback: function ($panelCollection) use ($panelIds) {
                    $this->areUserProvidedPanelsValid($panelIds);

                    $withDefaultOrder = $panelCollection->only($panelIds);

                    return collect($panelIds)
                        ->map(fn (string $id) => $withDefaultOrder[$id])
                        ->filter();
                },
                default: fn ($panelCollection) => $panelCollection
            )
            ->mapWithKeys(fn (Panel $panel) => [$panel->getId() => $this->isAbleToSwitchPanels() ? $this->getPanelUrl($panel) : null])
            ->when(
                value: filled($this->getSortOrder()),
                callback: fn ($panelCollection) => $panelCollection->sortKeys(descending: $this->getSortOrder() === 'desc')
            )
            ->toArray();
    }

    protected function getPanelUrl(Panel $panel)
    {
        return Uri::new()
            ->withPath('/' . ltrim($panel->getPath(), '/'))
            ->withHost(Arr::first($panel->getDomains()))
            ->toString();
    }

    public function getCurrentPanel(): Panel
    {
        return Filament::getCurrentPanel() ?? Filament::getDefaultPanel();
    }

    public function getRenderHook(): string
    {
        return $this->renderHook;
    }

    public function getRenderIconAsImage(): bool
    {
        return $this->renderIconAsImage;
    }
}
