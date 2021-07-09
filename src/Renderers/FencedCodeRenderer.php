<?php

namespace Spatie\CommonMarkShikiHighlighter\Renderers;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\Block\Renderer\FencedCodeRenderer as BaseFencedCodeRenderer;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Util\Xml;
use Spatie\CommonMarkShikiHighlighter\ShikiHighlighter;

class FencedCodeRenderer implements BlockRendererInterface
{
    protected ShikiHighlighter $highlighter;

    protected BaseFencedCodeRenderer $baseRenderer;

    public function __construct(ShikiHighlighter $codeBlockHighlighter)
    {
        $this->highlighter = $codeBlockHighlighter;

        $this->baseRenderer = new BaseFencedCodeRenderer();
    }

    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {
        $element = $this->baseRenderer->render($block, $htmlRenderer, $inTightList);
        ray($element->getContents())->blue();

        $element->setContents(
            $this->highlighter->highlight(
                $element->getContents(),
                $this->getSpecifiedLanguage($block)
            )
        );

        ray($element->getContents())->blue();

        return $element;
    }

    protected function getSpecifiedLanguage(FencedCode $block): ?string
    {
        $infoWords = $block->getInfoWords();

        if (empty($infoWords) || empty($infoWords[0])) {
            return null;
        }

        return Xml::escape($infoWords[0]);
    }
}
