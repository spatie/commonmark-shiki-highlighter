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
    public function __construct(
        protected string $theme
    ) {
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $shiki = new Shiki(defaultTheme: $this->theme);

        $codeBlockHighlighter = new ShikiHighlighter($shiki);

        $environment
            ->addRenderer(FencedCode::class, new FencedCodeRenderer($codeBlockHighlighter), 10)
            ->addRenderer(IndentedCode::class, new IndentedCodeRenderer($codeBlockHighlighter), 10);
    }
}
