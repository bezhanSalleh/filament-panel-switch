<a href="https://github.com/bezhansalleh/filament-panel-switch" class="filament-hidden">

![Panel Switch](https://repository-images.githubusercontent.com/674460446/9c4530cf-420e-4745-a401-0be18d1dd09d "Panel Switch")
</a>

<p align="center">
    <a href="https://filamentphp.com/docs/4.x/introduction/overview">
        <img alt="FILAMENT 4.x" src="https://img.shields.io/badge/FILAMENT-4.x-EBB304?style=for-the-badge">
    </a>
    <a href="https://packagist.org/packages/bezhansalleh/filament-panel-switch">
        <img alt="Packagist" src="https://img.shields.io/packagist/v/bezhansalleh/filament-panel-switch.svg?style=for-the-badge&logo=packagist">
    </a>
    <a href="https://github.com/bezhansalleh/filament-panel-switch/actions?query=workflow%3A"fix+php+code+styling"+branch%3A3.x" class="filament-hidden">
        <img alt="Code Style Passing" src="https://img.shields.io/github/actions/workflow/status/bezhansalleh/filament-panel-switch/fix-php-code-styling.yml?style=for-the-badge&logo=github&label=code%20style">
    </a>

<a href="https://packagist.org/packages/bezhansalleh/filament-panel-switch">
    <img alt="Downloads" src="https://img.shields.io/packagist/dt/bezhansalleh/filament-panel-switch.svg?style=for-the-badge" >
    </a>
</p>

# Panel Switch
The Panel Switch Plugin for Filament offers a robust and customizable component for switching between panels in applications built with FilamentPHP.
    
![Demo](https://raw.githubusercontent.com/bezhanSalleh/filament-panel-switch/master/art/modern-icon-demo.gif?raw=true "Modern Icon Demo") 
![Demo](https://raw.githubusercontent.com/bezhanSalleh/filament-panel-switch/master/art/modern-image-demo.gif?raw=true "Modern Image Demo") 
![Demo](https://raw.githubusercontent.com/bezhanSalleh/filament-panel-switch/master/art/demo.gif?raw=true "Simple Demo") 

<h2 class="filament-hidden">Table Of Contents</h2>
<ul class="filament-hidden">
<li>
<a href="#panel-switch">Panel Switch</a>
<ul>
<li>
<a href="#installation">Installation</a>
</li>
<li>
<a href="#configuration">Configuration</a>
<ul>
<li>
<a href="#design-or-style">Design or Style</a>
</li>
<li>
<a href="#labels">Labels</a>
</li>
<li>
<a href="#iconsimages">Icons/Images</a>
</li>
<li>
<a href="#iconimage-size">Icon/Image Size</a>
</li>
<li>
<a href="#visibility">Visibility</a>
</li>
<li>
<a href="#who-can-switch-panels">Who Can Switch Panels?</a>
</li>
<li>
<a href="#panels">Panel [New 1.0.7]</a>
</li>
<a href="#sort-order">Sort Order [New 1.0.7]</a>
</li>
<li>
<a href="#placement">Placement</a>
</li>
<li>
<a href="#usage">Usage</a>
</li>
<a href="#panel-exclusion">Panel Exclusion [@deprecated]</a>
</li>
</ul>
</li>
<li>
<a href="#changelog">Changelog</a>
</li>
<li>
<a href="#contributing">Contributing</a>
</li>
<li>
<a href="#security-vulnerabilities">Security Vulnerabilities</a>
</li>
<li>
<a href="#credits">Credits</a>
</li>
<li>
<a href="#license">License</a>
</li>
</ul>
</li>
</ul>

#### Compatibility

| Package Version | Filament Version | 
|----------------|---------------------|
| [v1](https://github.com/bezhanSalleh/filament-panel-switch/tree/1.x) | [v3](https://filamentphp.com/docs/3.x/panels/installation) |
| v2 | [v4](https://filamentphp.com/docs/4.x/introduction/overview) |

## Installation

You can install the package via composer:

```bash
composer require bezhansalleh/filament-panel-switch
```

> [!IMPORTANT]
> The plugin follows Filament's theming rules. So, to use the plugin create a custom theme if you haven't already, and add the following line to your `theme.css` file:

```php
@source '../../../../vendor/bezhansalleh/filament-panel-switch/resources/views/**/*.blade.php';
```
Now build your theme using: 
```bash
npm run build
```
--- 

Upon installation, the Plugin seamlessly integrates with Filament without any further setup.
Though the plugin works out-of-the-box, it's designed for customization. Delve into the Configuration section below for detailed customization options.

## Configuration
Start your custom configuration using the `configureUsing` method in your service provider's boot method:

```php
use BezhanSalleh\PanelSwitch\PanelSwitch;

PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    // Custom configurations go here
});
```
### Design or Style
By default, the Plugin uses Filament's [Modal Blade component](https://filamentphp.com/docs/3.x/support/blade-components/modal) as the modern design for the panel switch menu. But you can change it to the simple design by using the `simple()` method.

- #### Modern
    - ##### Modal Heading
      Set a custom Modal Heading for the Panel Switcher. By default, the modal heading is set to `Switch Panels`.
      ```php
          use BezhanSalleh\PanelSwitch\PanelSwitch;

          PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
              $panelSwitch->modalHeading('Available Panels');
          });
      ```
    - ##### Modal Width
      By default, the modal width is set to `screen` but you can use the options avaialbel for [Modal Blade component](https://filamentphp.com/docs/3.x/support/blade-components/modal#changing-the-modal-width).
      ```php
          use BezhanSalleh\PanelSwitch\PanelSwitch;

          PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
              $panelSwitch->modalWidth('sm');
          });
      ```
    - ##### Slide-Over
      You can use the `slideOver()` method to open a `slide-over` dialog instead of the modal.
        ```php
            use BezhanSalleh\PanelSwitch\PanelSwitch;
        
            PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
                $panelSwitch->slideOver();
            });
        ```
- #### Simple
  The `simple()` method transforms the panel switch menu to a dropdown list, allowing users to switch between panels directly from the list.
    ```php
        use BezhanSalleh\PanelSwitch\PanelSwitch;
    
        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch->simple();
        });
    ``` 
### Labels
By using `labels()` method you can provide textual representation for each panel. The keys of the array should be valid panel IDs, and the values can be either regular strings or Laravel's translatable strings:

```php
use BezhanSalleh\PanelSwitch\PanelSwitch;

PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch
        ->labels([
            'admin' => 'Custom Admin Label',
            'general_manager' => __('General Manager')
        ]);
});
```

### Icons/Images
Define icons/images for available panels using the `icons()` method which accepts an array. The keys of the array should be valid panel IDs. If using images instead of icons, set the `$asImage` parameter to `true` and the value of the array should be the path to the image meaning a valid url:

- **Icons**
```php
use BezhanSalleh\PanelSwitch\PanelSwitch;

PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {    
    $panelSwitch->icons([
        'validPanelId1' => 'heroicon-o-square-2-stack',
        'validPanelId2' => 'heroicon-o-star',
    ], $asImage = false);
});
```

- **Images**
```php
use BezhanSalleh\PanelSwitch\PanelSwitch;

PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {    
    $panelSwitch->icons([
        'validPanelId1' => 'https://raw.githubusercontent.com/bezhanSalleh/filament-panel-switch/3.x/art/banner.jpg',
        'validPanelId2' => 'https://raw.githubusercontent.com/bezhanSalleh/filament-panel-switch/3.x/art/banner.jpg',
    ], $asImage = true);
});
```

### Icon/Image Size
Use the `iconSize()` method to set the size of the icons/images. The default size is `128px`. The value provided will be multiplied by 4 and then used as the size of the icon/image.

```php
use BezhanSalleh\PanelSwitch\PanelSwitch;

PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {   
    // This would result in an icon/image size of 128 pixels.
    $panelSwitch->iconSize(32);  
});
```

### Visibility
By default, the package checks whether the user can access the panel if so the switch will be visible. You can further customize whether the panel switch should be shown.

```php
use BezhanSalleh\PanelSwitch\PanelSwitch;

PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) { 
    $panelSwitch
        ->visible(fn (): bool => auth()->user()?->hasAnyRole([
            'admin',
            'general_manager',
            'super_admin',
        ]));
});
```

### Who Can Switch Panels?
You might want an option in a situation where you want a group of your users to see the panel but not be able to switch panels. You can do that by using the `canSwitchPanels()` method.

```php
use BezhanSalleh\PanelSwitch\PanelSwitch;

PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch
        ->canSwitchPanels(fn (): bool => auth()->user()?->can('switch_panels'));
});
```

### Panels
By default all the panels available will be listed in the panel switch menu. But by providing an array of panel ids to the `panels()` method you can limit the panels that will be listed. 

```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch->panels([
        'admin',
        'dev',
        'app'
    ]);
});
```
Then `panels()` method also accepts a closure that returns an array of panel ids. This is useful when you want to dynamically determine the panels that will be listed. The plugin will also validate the panels to ensure that they are valid filament panels. If any of the panels provided are invalid, the plugin will throw an `InvalidArgumentException`.

### Sort Order
By default the panels will be listed in the order they were registered in `config/app.php`'s `providers` array or in the order they are provided through the `panels()` method. But you can opt-in to sort the panels either in `asc` or `desc` order via `sort()` method. 
```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch
        ...
        ->panels(['admin', 'dev', 'app']) // default order if `sort()` method not used 
        ->sort() // ['admin', 'app', 'dev']
        // ->sort(order: 'desc') // ['dev', 'app', 'admin']
        ...
        ;
});
```

### Placement
You can choose where the panel switch menu should be placed. By default panel switch menu is rendered via 'panels::global-search.before' `Hook`. But you can change it to anyone of the other available Filament [Render Hooks](https://filamentphp.com/docs/3.x/support/render-hooks#available-render-hooks).
```php
use BezhanSalleh\PanelSwitch\PanelSwitch;

PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch->renderHook('panels::global-search.after');
});
```

### Usage
The `Panel Switch Plugin` has a fluent api so you can chain the methods together and configure everything in one go.

```php
use BezhanSalleh\PanelSwitch\PanelSwitch;

PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch
        ->panels(['admin', 'app', 'dev'])
        ->heading('Available Panels')
        ->modalWidth('sm')
        ->slideOver()
        ->icons([
            'admin' => 'heroicon-o-square-2-stack',
            'app' => 'heroicon-o-star',
        ])
        ->iconSize(16)
        ->labels([
            'admin' => 'Admin Panel',
            'app' => 'SaaS Application'
        ]);
        
});
```

### Panel Exclusion 
**`@deprecated`** use **`panels()`** method instead.
By default all the panels available will be listed in the panel switch menu. But you can exclude some of them by using the excludes() method.
```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch->excludes([
        'saas'
    ]);
});
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-panel-switch-views"
```
### Testing

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
* In the `/filament-panel-switch` directory, create a branch for your fix, e.g. `fix/error-message.`
  
Install the packages in your app's `composer.json:`

```php
"require": {
    "bezhansalleh/filament-panel-switch": "dev-fix/error-message as main-dev",
},
"repositories": [
    {
        "type": "path",
        "url": "filament-panel-switch"
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
