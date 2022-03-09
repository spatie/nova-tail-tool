
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# A Laravel Nova tool to display the application log

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/nova-tail-tool.svg?style=flat-square)](https://packagist.org/packages/spatie/nova-tail-tool)
[![StyleCI](https://github.styleci.io/repos/143322266/shield?branch=master)](https://github.styleci.io/repos/143322266)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/nova-tail-tool.svg?style=flat-square)](https://packagist.org/packages/spatie/nova-tail-tool)

Have you always wanted to see your application log in your Nova app? Now you can!

![tail tool screenshot](/docs/tail-tool.png)

You can see the tool in action in [this video on YouTube](https://www.youtube.com/watch?v=I_KvN_gLl9Q).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/nova-tail-tool.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/nova-tail-tool)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the nova tool in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require spatie/nova-tail-tool
```

Next up, you must register the tool with Nova. This is typically done in the `tools` method of the `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvider.php

// ...

public function tools()
{
   return [
        // ...
        new \Spatie\TailTool\TailTool(),
    ];
}
```

## Usage

Click on the "Application log" menu item in your Nova app to see the log. Initially it will be empty. All new lines that are appended to the log will be shown.

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

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
