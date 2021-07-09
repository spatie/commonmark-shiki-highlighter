<?php

namespace Spatie\CommonMarkShikiHighlighter\Renderers;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\Block\Renderer\IndentedCodeRenderer as BaseIndentedCodeRenderer;
use League\CommonMark\ElementRendererInterface;
use Spatie\CommonMarkShikiHighlighter\ShikiHighlighter;
use function dd;

class IndentedCodeRenderer implements BlockRendererInterface
{
    protected ShikiHighlighter $highlighter;

    protected BaseIndentedCodeRenderer $baseRenderer;

    public function __construct(ShikiHighlighter $codeBlockHighlighter)
    {
        $this->highlighter = $codeBlockHighlighter;

        $this->baseRenderer = new BaseIndentedCodeRenderer();
    }

    public function render(
        AbstractBlock $block,
        ElementRendererInterface $htmlRenderer,
        $inTightList = false
    ): string {

        ray('indented render');
        $element = $this->baseRenderer->render($block, $htmlRenderer, $inTightList);

        $element->setContents(
            $this->highlighter->highlight($element->getContents())
        );

        return $element->getContents();
    }
}
