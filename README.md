# A Laravel Nova tool to display the application log

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/nova-tail-tool.svg?style=flat-square)](https://packagist.org/packages/spatie/nova-tail-tool)
[![Build Status](https://img.shields.io/travis/spatie/nova-tail-tool/master.svg?style=flat-square)](https://travis-ci.org/spatie/nova-tail-tool)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/nova-tail-tool.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/nova-tail-tool)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/nova-tail-tool.svg?style=flat-square)](https://packagist.org/packages/spatie/nova-tail-tool)

Have you always wanted to see your application log in your Nova app? Now you can!

![tail tool screenshot](https://spatie.github.io/nova-tail-tool/tail-tool.png)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require spatie/nova-tail-tool
```

Next up, you must register the tool with Nova. This is typically done in the `register` method of the `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvder.php

// ...

public function register()
{
    Nova::tools([
        // ...
        new \Spatie\NovaTailTool\NovaTailTool(),
    ]);
}
```

## Usage

Click on the "Application log" menu item in your Nova app to see the log.

### Authentication

By default the tool can only be seen in the local environment. To define a more specific access policy for the tool, you should use the `NovaTailTool::auth` method. The `auth` method accepts a callback which should return true or false, indicating whether the user should have access to the tool. Typically, you should call `NovaTailTool::auth` in the boot method a service provider:

```
// in a service provider

use Spatie\NovaTailTool\NovaTailTool

// ...

NovaTailTool::auth(function ($request) {
    // return true / false;
});
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
