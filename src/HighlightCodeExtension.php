<?php

namespace Spatie\CommonMarkShikiHighlighter;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Extension\ExtensionInterface;
use Spatie\CommonMarkShikiHighlighter\Renderers\FencedCodeRenderer;
use Spatie\CommonMarkShikiHighlighter\Renderers\IndentedCodeRenderer;
use Spatie\ShikiPhp\Shiki;

class HighlightCodeExtension implements ExtensionInterface
{
    protected ShikiHighlighter $shikiHighlighter;

    /**
     * @param string|array<string, string> $theme Can be a single theme or an array with a light and a dark theme.
     */
    public function __construct(mixed $theme = 'nord', ?Shiki $shiki = null, bool $throw = false)
    {
        $this->shikiHighlighter = new ShikiHighlighter($shiki ?? new Shiki($theme), $throw);
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addRenderer(FencedCode::class, new FencedCodeRenderer($this->shikiHighlighter), 10)
            ->addRenderer(IndentedCode::class, new IndentedCodeRenderer($this->shikiHighlighter), 10);
    }
}
