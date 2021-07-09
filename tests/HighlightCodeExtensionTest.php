<?php

namespace Spatie\CommonMarkShikiHighlighter\Tests;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use PHPUnit\Framework\TestCase;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;
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
    public function it_can_highlight_a_piece_of_fenced_code()
    {
        $markdown = <<<MD
        Here is a piece of fenced PHP code
        ```php
        <?php echo "Hello World"; ?>
        ```
        MD;

        $highlightedCode = $this->convertToHtml($markdown);

        $this->assertMatchesSnapshot($highlightedCode);
    }

    /** @test */
    public function it_can_highlight_a_piece_of_indented_code()
    {
        $markdown = <<<MD
        Here is a piece of indented PHP code

            <?php echo "Hello World"; ?>

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
