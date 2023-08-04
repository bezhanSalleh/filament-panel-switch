<!-- <a href="https://github.com/bezhansalleh/filament-panel-switch" class="filament-hidden"> -->
![Filament Panel Switch](https://github.com/[bezhanSalleh]/[filament-panel-switch]/blob/[main]/art/banner.jpg?raw=true)
<!-- </a> -->


[![Latest Version on Packagist](https://img.shields.io/packagist/v/bezhansalleh/filament-panel-switch.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-panel-switch)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-panel-switch/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/bezhansalleh/filament-panel-switch/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-panel-switch/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/bezhansalleh/filament-panel-switch/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bezhansalleh/filament-panel-switch.svg?style=flat-square)](https://packagist.org/packages/bezhansalleh/filament-panel-switch)


# Panel Switch
Easily switch between panels in Filament. Highly customizable

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
