<?php

namespace Spatie\CommonMarkShikiHighlighter\Renderers;

use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Renderer\Block\FencedCodeRenderer as BaseFencedCodeRenderer;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\Xml;
use Spatie\CommonMarkShikiHighlighter\ShikiHighlighter;

class FencedCodeRenderer implements NodeRendererInterface
{
    protected ShikiHighlighter $highlighter;

    protected BaseFencedCodeRenderer $baseRenderer;

    public function __construct(ShikiHighlighter $codeBlockHighlighter)
    {
        $this->highlighter = $codeBlockHighlighter;

        $this->baseRenderer = new BaseFencedCodeRenderer();
    }

    public function render(
        Node $node,
        ChildNodeRendererInterface $childRenderer
    ): string {
        $element = $this->baseRenderer->render($node, $childRenderer);

        $element->setContents(
            $this->highlighter->highlight(
                $element->getContents(),
                $this->getSpecifiedLanguage($node)
            )
        );

        return $element->getContents();
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
