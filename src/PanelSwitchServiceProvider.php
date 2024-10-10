<?php

namespace BezhanSalleh\PanelSwitch;

use Filament\Facades\Filament;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PanelSwitchServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-panel-switch';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasViews(static::$name);
    }

    public function packageBooted(): void
    {
        Filament::serving(fn () => PanelSwitch::boot());
    }
}