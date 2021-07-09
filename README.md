# Highlight code blocks with league/commonmark and Shiki

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/commonmark-shiki-highlighter.svg?style=flat-square)](https://packagist.org/packages/spatie/commonmark-shiki-highlighter)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/commonmark-shiki-highlighter/run-tests?label=tests)](https://github.com/spatie/commonmark-shiki-highlighter/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/commonmark-shiki-highlighter/Check%20&%20fix%20styling?label=code%20style)](https://github.com/spatie/commonmark-shiki-highlighter/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/commonmark-shiki-highlighter.svg?style=flat-square)](https://packagist.org/packages/spatie/commonmark-shiki-highlighter)

This package contains a block renderer for  [league/commonmark](https://github.com/thephpleague/commonmark) to highlight code blocks using [Shiki PHP](https://github.com/spatie/shiki-php).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/commonmark-shiki-highlighter.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/commonmark-shiki-highlighter)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/commonmark-shiki-highlighter
```

In your project, you should have the JavaScript package `shiki` installed. You can install it via npm

```bash
npm install shiki
```

or Yarn

```bash
yarn add shiki
```

## Usage

```php
$commonmarkShikiHighlighter = new Spatie\CommonmarkShikiHighlighter();
echo $commonmarkShikiHighlighter->echoPhrase('Hello, Spatie!');
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

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
