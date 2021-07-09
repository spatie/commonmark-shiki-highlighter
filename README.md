# Highlight code blocks with league/commonmark and Shiki

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/commonmark-shiki-highlighter.svg?style=flat-square)](https://packagist.org/packages/spatie/commonmark-shiki-highlighter)
[![Tests](https://github.com/spatie/commonmark-shiki-highlighter/actions/workflows/run-tests.yml/badge.svg)](https://github.com/spatie/commonmark-shiki-highlighter/actions/workflows/run-tests.yml)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/commonmark-shiki-highlighter/Check%20&%20fix%20styling?label=code%20style)](https://github.com/spatie/commonmark-shiki-highlighter/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/commonmark-shiki-highlighter.svg?style=flat-square)](https://packagist.org/packages/spatie/commonmark-shiki-highlighter)

This package contains a block renderer for [league/commonmark](https://github.com/thephpleague/commonmark) to highlight code blocks using [Shiki PHP](https://github.com/spatie/shiki-php).

This package also ships with the following extra languages, on top of the [100+ that Shiki supports](https://github.com/shikijs/shiki/tree/master/docs/languages.md) out of the box:

- Antlers
- Blade

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

Here's how we can create a function that can convert markdown to HTML with all code snippets highlighted. Inside the function will create a new `CommonMarkConverter` that uses the `HighlightCodeExtension` provided by this package.

```php
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;

function convertToHtml(string $markdown, string $theme): string
{
    $environment = Environment::createCommonMarkEnvironment()
        ->addExtension(new HighlightCodeExtension($theme));

    $commonMarkConverter = new CommonMarkConverter(environment: $environment);

    return $commonMarkConverter->convertToHtml($markdown);
}
```

## Using themes

The `$theme` argument on `HighlightCodeExtension` expects the name of [one of the many themes](https://github.com/shikijs/shiki/blob/master/docs/themes.md) that Shiki supports.

Alternatively, you can use a custom theme. Shiki supports any [VSCode themes](https://code.visualstudio.com/docs/getstarted/themes). You can load a theme simply by passing an absolute path of a theme file to the `$theme` argument.

## A word on performance

Highlighting with Shiki is a resource intensive process. We highly recommend using some form of caching when you use this package on a high traffic website.

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
