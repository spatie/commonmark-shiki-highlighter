<?php

namespace Spatie\CommonMarkShikiHighlighter;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\Block\Renderer\IndentedCodeRenderer as BaseIndentedCodeRenderer;
use League\CommonMark\ElementRendererInterface;

class IndentedCodeRenderer implements BlockRendererInterface
{
    protected CodeBlockHighlighter $highlighter;

    protected BaseIndentedCodeRenderer $baseRenderer;

    public function __construct()
    {
        $this->highlighter = new CodeBlockHighlighter();

        $this->baseRenderer = new BaseIndentedCodeRenderer();
    }

    public function render(
        AbstractBlock $block,
        ElementRendererInterface $htmlRenderer,
        $inTightList = false
    ) {
        $element = $this->baseRenderer->render($block, $htmlRenderer, $inTightList);

        $element->setContents(
            $this->highlighter->highlight($element->getContents())
        );

        return $element;
    }
}
