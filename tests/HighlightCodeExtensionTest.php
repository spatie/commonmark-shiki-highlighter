<?php

namespace Spatie\CommonMarkShikiHighlighter\Tests;

use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use PHPUnit\Framework\TestCase;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;
use Spatie\CommonMarkShikiHighlighter\Renderers\FencedCodeRenderer;
use Spatie\CommonMarkShikiHighlighter\Renderers\IndentedCodeRenderer;
use Spatie\CommonMarkShikiHighlighter\ShikiHighlighter;
use Spatie\ShikiPhp\Shiki;
use Spatie\Snapshots\MatchesSnapshots;

class HighlightCodeExtensionTest extends TestCase
{
    use MatchesSnapshots;

    public function setUp(): void
    {
        parent::setUp();

        ray()->newScreen($this->getName());
    }

    /** @test */
    public function it_can_highlight_a_piece_of_code()
    {
        $markdown = <<<MD
        Here is a piece of my favourite PHP code
        ```php
        <?php echo "Hello World"; ?>
        ```
        MD;

        $highlightedCode = $this->convertToHtml($markdown);

        $this->assertMatchesSnapshot($highlightedCode);
    }

    protected function convertToHtml(string $markdown): string
    {
        $environment = Environment::createCommonMarkEnvironment()
            ->addExtension(new HighlightCodeExtension('nord'));

        $commonMarkConverter = new CommonMarkConverter(environment: $environment);
        return $commonMarkConverter->convertToHtml($markdown);
    }
}