<?php

declare(strict_types=1);

namespace BezhanSalleh\PanelSwitch\Concerns;

use Filament\Facades\Filament;
use InvalidArgumentException;

trait HasPanelValidator
{
    /**
     * @throws InvalidArgumentException
     */
    public function areUserProvidedPanelsValid(array $panelIds): void
    {
        $validated = collect($panelIds)->diff(collect(Filament::getPanels())->keys()->toArray());

        if ($validated->isNotEmpty()) {
            throw new InvalidArgumentException("Invalid Filament Panel. Make sure the panel ids passed to the `Panel Switch`, are valid and do exist. [`{$validated->implode(', ')}`]");
        }
    }
}