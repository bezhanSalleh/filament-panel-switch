<?php

namespace BezhanSalleh\PanelSwitch\Tests;

use BezhanSalleh\PanelSwitch\PanelSwitchServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Support\SupportServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'BezhanSalleh\\PanelSwitch\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentServiceProvider::class,
            LivewireServiceProvider::class,
            SupportServiceProvider::class,
            PanelSwitchServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_filament-panel-switch_table.php.stub';
        $migration->up();
        */
    }
}
