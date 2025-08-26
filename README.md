# This is my package filament-indonesia-regions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/triptasoft/filament-indonesia-regions.svg?style=flat-square)](https://packagist.org/packages/triptasoft/filament-indonesia-regions)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/triptasoft/filament-indonesia-regions/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/triptasoft/filament-indonesia-regions/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/triptasoft/filament-indonesia-regions/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/triptasoft/filament-indonesia-regions/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/triptasoft/filament-indonesia-regions.svg?style=flat-square)](https://packagist.org/packages/triptasoft/filament-indonesia-regions)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require triptasoft/filament-indonesia-regions
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-indonesia-regions-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-indonesia-regions-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-indonesia-regions-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentIndonesiaRegions = new Triptasoft\FilamentIndonesiaRegions();
echo $filamentIndonesiaRegions->echoPhrase('Hello, Triptasoft!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [hazbu](https://github.com/triptasoft)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
