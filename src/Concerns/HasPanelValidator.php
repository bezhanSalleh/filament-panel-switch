<?php

declare(strict_types=1);

namespace BezhanSalleh\PanelSwitch\Concerns;

use Closure;
use InvalidArgumentException;
use Filament\Facades\Filament;

trait HasPanelValidator
{
    /**
     * @throws InvalidArgumentException
     */
    public function areUserProvidedPanelsValid(array $panelIds): void
    {
        $validated = collect($panelIds)->diff(collect(Filament::getPanels())->keys()->toArray());

        if ($validated->isNotEmpty()) {
            throw new InvalidArgumentException("Invalid panel IDs: {$validated->implode(', ')}");
        }
    }
}
