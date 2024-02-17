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

    public function __construct(string $theme = 'nord', Shiki $shiki = null)
    {
        $this->shikiHighlighter = new ShikiHighlighter($shiki ?? new Shiki($theme));
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addRenderer(FencedCode::class, new FencedCodeRenderer($this->shikiHighlighter), 10)
            ->addRenderer(IndentedCode::class, new IndentedCodeRenderer($this->shikiHighlighter), 10);
    }
}
