<?php

namespace Spatie\CommonMarkShikiHighlighter;

use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\ConfigurableEnvironmentInterface;
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

    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $shiki = new Shiki(defaultTheme: $this->theme);

        $codeBlockHighlighter = new ShikiHighlighter($shiki);

        $environment
            ->addBlockRenderer(FencedCode::class, new FencedCodeRenderer($codeBlockHighlighter), 10)
            ->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer($codeBlockHighlighter), 10);
    }
}
