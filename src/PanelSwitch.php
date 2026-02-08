<?php

namespace BezhanSalleh\PanelSwitch;

use Closure;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Support\Components\Component;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Arr;
use League\Uri\Uri;

class PanelSwitch extends Component
{
    use Concerns\HasPanelValidator;

    protected bool | Closure $isModalSlideOver = false;

    protected string | Closure | null $modalWidth = null;

    protected bool | Closure $isSimple = false;

    protected array | Closure $icons = [];

    protected array | Closure $darkIcons = [];

    protected int | Closure | null $iconSize = null;

    protected array | Closure $labels = [];

    protected array | Closure | null $panels = null;

    protected bool $renderIconAsImage = false;

    protected string | Closure $modalHeading = 'Switch Panels';

    protected ?string $renderHook = null;

    protected ?string $sortOrder = null;

    public static function make(): static
    {
        $static = app(static::class);

        $static->configure();

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

                $currentPanel = $static->getCurrentPanel();

                return view('filament-panel-switch::panel-switch-menu', [
                    'currentPanel' => $currentPanel,
                    'darkIcons' => $static->getDarkIcons(),
                    'hasTopbar' => $currentPanel->hasTopbar(),
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

    public function modalHeading(string | Closure $modalHeading): static
    {
        $this->modalHeading = $modalHeading;

        return $this;
    }

    public function icons(array | Closure $icons, bool $asImage = false): static
    {
        $this->renderIconAsImage = $asImage;
        $this->icons = $icons;

        return $this;
    }

    public function darkIcons(array | Closure $darkIcons): static
    {
        $this->darkIcons = $darkIcons;

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

    public function sort(string $order = 'asc'): static
    {
        $this->sortOrder = $order;

        return $this;
    }

    public function getModalHeading(): string
    {
        return (string) $this->evaluate($this->modalHeading);
    }

    public function getIcons(): array
    {
        $icons = (array) $this->evaluate($this->icons);

        if ($this->renderIconAsImage) {
            $this->ensureIconsAreUrls($icons);
        }

        return $icons;
    }

    public function getDarkIcons(): array
    {
        $darkIcons = (array) $this->evaluate($this->darkIcons);

        if ($this->renderIconAsImage) {
            $this->ensureIconsAreUrls($darkIcons);
        }

        return $darkIcons;
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
        $user = auth()?->user();

        if (blank($user)) {
            return false;
        }

        if (method_exists($user, 'canSwitchPanels')) {
            return $user->canSwitchPanels();
        }

        return true;
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
        return count($this->getPanels()) >= 2;
    }

    public function getSortOrder(): ?string
    {
        return $this->evaluate($this->sortOrder);
    }

    public function getPanels(): array
    {
        $panelIds = (array) $this->evaluate($this->panels);

        return collect(Filament::getPanels())
            ->filter($this->canUserAccessPanel(...))
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
        return Filament::getCurrentOrDefaultPanel();
    }

    public function getRenderHook(): string
    {
        return match (true) {
            filled($this->renderHook) => $this->renderHook,
            $this->getCurrentPanel()->hasTopbar() => PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
            default => PanelsRenderHook::USER_MENU_BEFORE
        };
    }

    public function getRenderIconAsImage(): bool
    {
        return (bool) $this->evaluate($this->renderIconAsImage);
    }

    private function ensureIconsAreUrls(array $icons): void
    {
        foreach ($icons as $panel => $icon) {
            if (! str($icon)->startsWith(['http://', 'https://'])) {
                throw new \InvalidArgumentException("The icon for the [{$panel}] panel must be a URL starting with http:// or https://.");
            }
        }
    }

    protected function canUserAccessPanel(Panel $panel): bool
    {
        $user = auth()->user();

        if (blank($user)) {
            return false;
        }

        if (method_exists($user, 'canAccessPanel')) {
            return $user->canAccessPanel($panel);
        }

        return true;
    }
}