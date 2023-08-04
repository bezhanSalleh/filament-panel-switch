<?php

namespace BezhanSalleh\PanelSwitch;

use Closure;
use Filament\Panel;
use Filament\Support\Concerns\Configurable;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Support\Facades\FilamentView;

class PanelSwitch
{
    use Configurable;
    use EvaluatesClosures;

    protected array $excludes = [];

    protected bool | Closure | null $visible = null;

    protected bool | Closure | null $canSwitchPanel = true;

    protected string $renderHook = 'panels::topbar.start';

    public static function make(): static
    {
        $static = app(static::class);
        $static->configure();

        return $static;
    }

    public static function boot(): void
    {
        $static = static::make();

        $static->visible(function () {
            if (($user = auth()->user()) === null) {
                return false;
            }

            if (method_exists($user, 'hasRole')) {
                return $user->hasRole('super_admin');
            }

            return true;
        });

        FilamentView::registerRenderHook(
            name: $static->getRenderHook(),
            hook: function () use ($static) {
                if (! $static->isVisible()) {
                    return '';
                }

                return view('filament-panel-switch::panel-switch-menu', [
                    'panels' => $static->getPanels(),
                    'currentPanel' => $static->getCurrentPanel(),
                    'canSwitchPanels' => $static->isAbleToSwitchPanels(),
                ]);
            },
        );
    }

    public function excludes(array $panelIds): static
    {
        $this->excludes = $panelIds;

        return $this;
    }

    public function getExcludes(): array
    {
        return $this->excludes;
    }

    public function visible(bool | Closure $visible): static
    {
        $this->visible = $visible;

        return $this;
    }

    public function isVisible(): bool
    {
        return $this->evaluate($this->visible);
    }

    public function canSwitchPanels(bool | Closure $condition): static
    {
        $this->canSwitchPanel = $condition;

        return $this;
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

    public function renderHook(string $hook): static
    {
        $this->renderHook = $hook;

        return $this;
    }

    public function getRenderHook(): string
    {
        return $this->renderHook;
    }

    /**
     * @return array<string, Panel>
     */
    public function getPanels(): array
    {
        return collect(filament()->getPanels())
            ->reject(fn (Panel $panel) => in_array($panel->getId(), $this->excludes))
            ->toArray();
    }

    public function getCurrentPanel(): Panel
    {
        return filament()->getCurrentPanel();
    }
}
