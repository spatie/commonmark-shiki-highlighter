<?php

namespace Spatie\CommonMarkShikiHighlighter;

use Exception;
use Spatie\ShikiPhp\Shiki;

class ShikiHighlighter
{
    public function __construct(
        protected Shiki $shiki
    ) {
    }

    public function highlight(string $codeBlock, ?string $infoLine = null): string
    {
        $codeBlockWithoutTags = strip_tags($codeBlock);

        $contents = htmlspecialchars_decode($codeBlockWithoutTags);

        [$contents, $addLines, $deleteLines] = $this->parseAddedAndDeletedLines($contents);

        $definition = $this->parseLangAndLines($infoLine);

        $language = $definition['lang'] ?? 'php';

        try {
            $highlightedContents = $this->shiki->highlightCode(
                code: $contents,
                language: $language,
                options: [
                    'addLines' => $addLines,
                    'deleteLines' => $deleteLines,
                    'highlightLines' => $definition['highlightLines'],
                    'focusLines' => $definition['focusLines'],
                ],
            );
        } catch (Exception) {
            $highlightedContents = $codeBlock;
        }

        return $highlightedContents;
    }

    protected function parseLangAndLines(?string $language): array
    {
        $parsed = [
            'lang' => $language,
            'highlightLines' => [],
            'focusLines' => [],
        ];

        if ($language === null) {
            return $parsed;
        }

        $bracePosition = strpos($language, '{');

        if ($bracePosition === false) {
            return $parsed;
        }

        preg_match_all('/{([^}]*)}/', $language, $matches);

        $parsed['lang'] = substr($language, 0, $bracePosition);
        $parsed['highlightLines'] = array_map('trim', explode(',', $matches[1][0] ?? ''));
        $parsed['focusLines'] = array_map('trim', explode(',', $matches[1][1] ?? ''));

        return $parsed;
    }

    private function parseAddedAndDeletedLines(string $contents): array
    {
        $addLines = [];
        $deleteLines = [];

        $contentLines = explode("\n", $contents);
        $contentLines = array_map(function (string $line, int $index) use (&$addLines, &$deleteLines) {
            if (str_starts_with($line, '+ ')) {
                $addLines[] = $index + 1;
                $line = substr($line, 2);
            }

            if (str_starts_with($line, '- ')) {
                $deleteLines[] = $index + 1;
                $line = substr($line, 2);
            }

            return $line;
        }, $contentLines, array_keys($contentLines));

        return [
            implode("\n", $contentLines),
            $addLines,
            $deleteLines,
        ];
    }
}
