<a href="https://github.com/bezhansalleh/filament-panel-switch" class="filament-hidden">

![Panel Switch](https://repository-images.githubusercontent.com/674460446/9c4530cf-420e-4745-a401-0be18d1dd09d "Panel Switch")
</a>

<p align="center">
    <a href="https://filamentphp.com/docs/4.x/introduction/overview">
        <img alt="FILAMENT 4.x" src="https://img.shields.io/badge/FILAMENT-4.x-EBB304?style=for-the-badge">
    </a>
    <a href="https://filamentphp.com/docs/5.x/introduction/overview">
        <img alt="FILAMENT 5.x" src="https://img.shields.io/badge/FILAMENT-5.x-EBB304?style=for-the-badge">
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
<a href="#panel-access--navigation">Panel Access & Navigation</a>
</li>
<li>
<a href="#design-or-style">Design or Style</a>
</li>
<li>
<a href="#labels">Labels</a>
</li>
<li>
<a href="#icons">Icons</a>
</li>
<li>
<a href="#sort-order">Sort Order</a>
</li>
<li>
<a href="#placement">Placement</a>
</li>
<li>
<a href="#full-example">Full Example</a>
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
| [1.x](https://github.com/bezhanSalleh/filament-panel-switch/tree/1.x) | [3.x](https://filamentphp.com/docs/3.x/panels/installation) |
| 2.x | [4.x](https://filamentphp.com/docs/4.x/introduction/overview) & [5.x](https://filamentphp.com/docs/5.x/introduction/overview) |

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
### Panel Access & Navigation
The panel switch is automatically visible when the authenticated user has access to two or more panels. Panel access is determined via the `canAccessPanel` method on your User model — no additional configuration needed. Panels the user cannot access are automatically hidden from the switch.

To further limit which panels appear in the switch, use the `panels()` method:

```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch->panels([
        'admin',
        'dev',
        'app'
    ]);
});
```
The `panels()` method also accepts a closure that returns an array of panel ids. This is useful when you want to dynamically determine the panels that will be listed. The plugin will also validate the panels to ensure that they are valid filament panels. If any of the panels provided are invalid, the plugin will throw an `InvalidArgumentException`.

### Design or Style
The plugin supports two design styles:

- **Modern** (default) — Uses Filament's [Modal Blade component](https://filamentphp.com/docs/3.x/support/blade-components/modal). You can customize the modal heading, [width](https://filamentphp.com/docs/3.x/support/blade-components/modal#changing-the-modal-width), or use a slide-over:

    ```php
    PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
        $panelSwitch
            ->modalHeading('Available Panels')
            ->modalWidth('sm')
            ->slideOver();
    });
    ```

- **Simple** — A dropdown list for switching panels directly:

    ```php
    PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
        $panelSwitch->simple();
    });
    ```

For full control over the look and feel, you can publish the views and make your own adjustments:

```bash
php artisan vendor:publish --tag="filament-panel-switch-views"
```

### Labels
Provide custom labels for each panel. The keys should be valid panel IDs, and values can be strings or translatable strings:

```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch
        ->labels([
            'admin' => 'Custom Admin Label',
            'general_manager' => __('General Manager')
        ]);
});
```

### Icons
Define icons for each panel using the `icons()` method. The keys should be valid panel IDs:

```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {    
    $panelSwitch->icons([
        'admin' => 'heroicon-o-square-2-stack',
        'app' => 'heroicon-o-star',
    ]);
});
```

For images instead of icons, set the `asImage` parameter to `true`:

```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {    
    $panelSwitch->icons([
        'admin' => 'https://example.com/admin.jpg',
        'app' => 'https://example.com/app.jpg',
    ], asImage: true);
});
```

Use `iconSize()` to customize the size (default `128px`). The value is multiplied by 4:

```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch->iconSize(32); // 128px
});
```

### Sort Order
By default panels are listed in registration order, or in the order provided via `panels()`. Use `sort()` to sort alphabetically:

```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch
        ->panels(['admin', 'dev', 'app'])
        ->sort();         // ascending: ['admin', 'app', 'dev']
        // ->sort('desc') // descending: ['dev', 'app', 'admin']
});
```

### Placement
By default the panel switch is rendered via the `panels::global-search.before` render hook. You can change this to any available Filament [Render Hook](https://filamentphp.com/docs/3.x/support/render-hooks#available-render-hooks):

```php
PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
    $panelSwitch->renderHook('panels::global-search.after');
});
```

### Full Example

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