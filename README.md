# Highlight code blocks with league/commonmark and Shiki

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/commonmark-shiki-highlighter.svg?style=flat-square)](https://packagist.org/packages/spatie/commonmark-shiki-highlighter)
[![Tests](https://github.com/spatie/commonmark-shiki-highlighter/actions/workflows/run-tests.yml/badge.svg)](https://github.com/spatie/commonmark-shiki-highlighter/actions/workflows/run-tests.yml)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/spatie/commonmark-shiki-highlighter/Check%20&%20fix%20styling?label=code%20style)](https://github.com/spatie/commonmark-shiki-highlighter/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/commonmark-shiki-highlighter.svg?style=flat-square)](https://packagist.org/packages/spatie/commonmark-shiki-highlighter)

This package contains a block renderer for [league/commonmark](https://github.com/thephpleague/commonmark) to highlight code blocks using [Shiki PHP](https://github.com/spatie/shiki-php).

This package also ships with the following extra languages, on top of the [100+ that Shiki supports](https://github.com/shikijs/shiki/tree/master/docs/languages.md) out of the box:

- Antlers
- Blade

If you're using Laravel, make sure to look at our [spatie/laravel-markdown](https://github.com/spatie/laravel-markdown) package which offers easy integration with Shiki in laravel projects.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/commonmark-shiki-highlighter.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/commonmark-shiki-highlighter)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/commonmark-shiki-highlighter
```

In your project, you must have the JavaScript package [`shiki`](https://github.com/shikijs/shiki) installed, otherwise the `<pre>` element will not be present in the output. 

You can install it via npm

```bash
npm install shiki
```

or Yarn

```bash
yarn add shiki
```

## Usage

Here's how we can create a function that can convert markdown to HTML with all code snippets highlighted. Inside the function will create a new `MarkdownConverter` that uses the `HighlightCodeExtension` provided by this package.

```php
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;

function convertToHtml(string $markdown, string $theme): string
{
    $environment = (new Environment())
        ->addExtension(new CommonMarkCoreExtension())
        ->addExtension(new HighlightCodeExtension(theme: $theme));

    $markdownConverter = new MarkdownConverter(environment: $environment);

    return $markdownConverter->convertToHtml($markdown);
}
```

Alternatively, you can inject an already instantiated `Shiki` instance into the `HighlightCodeExtension`:

```php
use Spatie\ShikiPhp\Shiki;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;

$environment->addExtension(new HighlightCodeExtension(shiki: new Shiki()));
```

## Using themes

The `$theme` argument on `HighlightCodeExtension` expects the name of [one of the many themes](https://github.com/shikijs/shiki/blob/master/docs/themes.md) that Shiki supports.

Alternatively, you can use a custom theme. Shiki [supports](https://github.com/shikijs/shiki/blob/master/docs/themes.md) any [VSCode themes](https://code.visualstudio.com/docs/getstarted/themes). You can load a theme simply by passing an absolute path of a theme file to the `$theme` argument.

## Marking lines as highlighted, added, deleted and focus

You can mark lines using the Markdown info tag as highlighted or focused. You can prefix lines with `+ ` or `- ` to mark them as added or deleted.
In the first pair of brackets, you can specify line numbers that should be highlighted. In an optional second pair you can specify which lines should be focused on.

```md
```php{1,2}{3}
<?php
echo "We're highlighting line 1 and 2";
echo "And focusing line 3";
```

```md
```php
<?php
+ echo "This line is marked as added";
- echo "This line is marked as deleted";
```

### More syntax examples for highlighting & focusing

Line numbers start at 1.

\`\`\`php - Don't highlight any lines  

\`\`\`php{4} - Highlight just line 4  
\`\`\`php{4-6} - Highlight the range of lines from 4 to 6 (inclusive)  
\`\`\`php{1,5} - Highlight just lines 1 and 5 on their own  
\`\`\`php{1-3,5} - Highlight 1 through 3 and then 5 on its own  
\`\`\`php{5,7,2-3} - The order of lines don't matter. However, specifying 3-2 will not work.

\`\`\`php{}{4} - Focus just line 4  
\`\`\`php{}{4-6} - Focus the range of lines from 4 to 6 (inclusive)  
\`\`\`php{}{1,5} - Focus just lines 1 and 5 on their own  
\`\`\`php{}{1-3,5} - Focus 1 through 3 and then 5 on its own  
\`\`\`php{}{5,7,2-3} - The order of lines don't matter. However, specifying 3-2 will not work.

### Styling highlighted lines

When you mark lines as highlighted, added, deleted or focused, Shiki will apply some classes to those lines. You should add some CSS to your page to style those lines. Here's a bit of example CSS to get you started.

```css
.shiki .highlight {
    background-color: hsl(197, 88%, 94%);
    padding: 3px 0;
}

.shiki .add {
    background-color: hsl(136, 100%, 96%);
    padding: 3px 0;
}

.shiki .del {
    background-color: hsl(354, 100%, 96%);
    padding: 3px 0;
}

.shiki.focus .line:not(.focus) {
    transition: all 250ms;
    filter: blur(2px);
}

.shiki.focus:hover .line {
    transition: all 250ms;
    filter: blur(0);
}
```

## Throwing on exceptions

By default, the Shiki highlighter will not throw when something goes wrong and just return the non-highlighted code. If you want to throw the exception anyway, instantiate the highlighter with `throw` as `true`:

```php
$environment = (new Environment())
    ->addExtension(new CommonMarkCoreExtension())
    ->addExtension(new HighlightCodeExtension(theme: $theme, throw: true));
```

## A word on performance

Highlighting with Shiki is a resource intensive process. We highly recommend using some form of caching.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## Alternatives

If you don't want to install and handle Shiki yourself, take a look at [Torchlight](https://torchlight.dev), which can highlight your code with minimal setup.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
