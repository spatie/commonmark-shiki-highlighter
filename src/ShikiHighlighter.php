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

        $definition = $this->parseLangAndLines($infoLine);

        $language = $definition['lang'] ?? 'php';

        try {
            $highlightedContents = $this->shiki->highlightCode($contents, $language);
        } catch (Exception) {
            $highlightedContents = $contents;
        }

        return $highlightedContents;
    }

    protected function parseLangAndLines(?string $language): array
    {
        $parsed = [
            'lang' => $language,
            'lines' => [],
        ];

        if ($language === null) {
            return $parsed;
        }

        $bracePos = strpos($language, '{');

        if ($bracePos === false) {
            return $parsed;
        }

        $parsed['lang'] = substr($language, 0, $bracePos);
        $lineDef = substr($language, $bracePos + 1, -1);
        $lineNums = explode(',', $lineDef);

        foreach ($lineNums as $lineNum) {
            if (! str_contains($lineNum, '-')) {
                $parsed['lines'][intval($lineNum)] = true;

                continue;
            }

            $extremes = explode('-', $lineNum);

            if (count($extremes) !== 2) {
                continue;
            }

            $start = intval($extremes[0]);
            $end = intval($extremes[1]);

            foreach (range($start, $end) as $i) {
                $parsed['lines'][$i] = true;
            }
        }

        return $parsed;
    }
}
