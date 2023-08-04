<a href="https://github.com/bezhansalleh/filament-panel-switch" class="filament-hidden">

![Panel Switch](./art/banner.jpg?raw=true "Panel Switch")
</a>

<p align="left">
    <a href="https://filamentphp.com/docs/3.x/panels/installation">
        <img alt="FILAMENT 8.x" src="https://img.shields.io/badge/FILAMENT-3.x-EBB304?style=for-the-badge">
    </a>
    <a href="https://packagist.org/packages/bezhansalleh/filament-panel-switch">
        <img alt="Packagist" src="https://img.shields.io/packagist/v/bezhansalleh/filament-panel-switch.svg?style=for-the-badge&logo=packagist">
    </a>
    <a href="https://github.com/bezhansalleh/filament-panel-switch/actions?query=workflow%3Arun-tests+branch%3Amain" class="filament-hidden">
        <img alt="Tests Passing" src="https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-panel-switch/run-tests.yml?style=for-the-badge&logo=github&label=tests">
    </a>
    <a href="https://github.com/bezhansalleh/filament-panel-switch/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain" class="filament-hidden">
        <img alt="Code Style Passing" src="https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-panel-switch/run-laravel-pint.yml?style=for-the-badge&logo=github&label=code%20style">
    </a>

<a href="https://packagist.org/packages/bezhansalleh/filament-panel-switch">
    <img alt="Downloads" src="https://img.shields.io/packagist/dt/bezhansalleh/filament-panel-switch.svg?style=for-the-badge" >
    </a>
</p>

# Panel Switch
Easily switch between panels in Filament.
    
![Demo](./art/demo.gif?raw=true "Demo") 


## Installation

You can install the package via composer:

```bash
composer require bezhansalleh/filament-panel-switch
```
That's it, no other steps are required.
## Configuration
Right now you can configure a couple things for the plugin. By calling the `PanelSwitch` class's `configureUsing()` method inside a service provider's `boot()` method.
```php
public function boot()
{
    PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
        //
    });
}
```

##### Visibility
By default, the package checks whether you have `Spatie permissions` plugin installed and checks for a role called `super_admin`. You can further customize whether the panel switch should be shown.

```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch
        ->visible(fn (): bool => auth()->user()?->hasAnyRole([
            'admin',
            'general_manager'
            'super_admin',
        ]));
});
```

##### Who Can Switch Panels?
You might want an option in a situation where you want a group of your users to see the panel but not be able to switch panels. You can do that by using the `canSwitchPanels()` method.

```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch
        ->canSwitchPanels(fn (): bool => auth()->user()?->can('switch_panels'));
});
```

#### Panel Exclusion
By default all the panels available will be listed in the panel switch menu. But you can exclude some of them by using the `excludes()` method.

```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch->excludes([
        'saas'
    ]);
});
```

##### Placement
You can choose where the panel switch menu should be placed. By default panel switch menu is rendered via 'panels::topbar.start' `Hook`. But you can change it to anyone of the other available hooks.
```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch->renderHook('panels::global-search.before');
});
```

The `PanelSwitch` has a fluent api so you can chain the methods together and configure everything in one go.

```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch
        ->visible(fn (): bool => auth()->user()?->hasAnyRole([
            'admin',
            'general_manager'
            'super_admin',
        ]))
        ->canSwitchPanels(fn (): bool => auth()->user()?->can('switch_panels'))
        ->excludes([
            'saas'
        ])
        ->renderHook('panels::global-search.before');
});
```
## Theming
By default the plugin uses the default filament theme, but you can customize it by adding the view path into the `content` array of your `panels'` `tailwind.config.js` file:

```php
export default {
    content: [
        // ...
        './vendor/bezhansalleh/filament-panel-switch/resources/views/panel-switch-menu.blade.php',
    ],
    // ...
}
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-panel-switch-views"
```
## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

If you want to contribute to this packages, you may want to test it in a real Filament project:

* Fork this repository to your GitHub account.
* Create a Filament app locally.
* Clone your fork in your Filament app's root directory.
* In the `/filament-panel-swtich` directory, create a branch for your fix, e.g. `fix/error-message.`
  
Install the packages in your app's `composer.json:`

```php
"require": {
    "bezhansalleh/filament-panel-switch": "dev-fix/error-message as main-dev",
},
"repositories": [
    {
        "type": "path",
        "url": "filament-panel-swtich"
    }
]
```
Now, run composer update.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Bezhan Salleh](https://github.com/bezhanSalleh)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
