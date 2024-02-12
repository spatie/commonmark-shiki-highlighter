<?php

namespace Spatie\CommonMarkShikiHighlighter\Tests;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;
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

    /** @test */
    public function it_can_mark_lines_as_highlighted_added_deleted_and_focus()
    {
        $markdown = <<<MD
        Here is a piece of fenced PHP code
        ```php{4,5}{6,7}
        <?php
        + echo "This is an added line";
        - echo "This is a deleted line";
        echo "We will highlight line 4";
        echo "We will highlight line 5";
        echo "We will focus line 6";
        echo "We will focus line 7";
        ```
        MD;

        $highlightedCode = $this->convertToHtml($markdown);

        $this->assertMatchesSnapshot($highlightedCode);
    }

    /** @test */
    public function can_create_with_a_shiki_instance()
    {
        $markdown = <<<MD
        Here is a piece of indented PHP code

            <?php echo "Hello World"; ?>

        MD;

        $environment = (new Environment())
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new HighlightCodeExtension(shiki: new Shiki()));

        $commonMarkConverter = new MarkdownConverter(environment: $environment);

        $highlightedCode = $commonMarkConverter->convertToHtml($markdown);

        $this->assertMatchesSnapshot((string) $highlightedCode);
    }

    protected function convertToHtml(string $markdown): string
    {
        $environment = (new Environment())
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new HighlightCodeExtension('nord'));

        $commonMarkConverter = new MarkdownConverter(environment: $environment);

        return $commonMarkConverter->convertToHtml($markdown);
    }
}
