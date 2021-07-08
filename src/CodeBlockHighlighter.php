<?php

namespace Spatie\CommonMarkShikiHighlighter;

use Exception;
use Spatie\ShikiPhp\Shiki;

class CodeBlockHighlighter
{
    protected Shiki $shiki;

    public function __construct()
    {
        $this->shiki = new Shiki();
    }

    public function highlight(string $codeBlock, ?string $infoLine = null)
    {
        $codeBlockWithoutTags = strip_tags($codeBlock);

        $contents = htmlspecialchars_decode($codeBlockWithoutTags);

        $definition = $this->parseLangAndLines($infoLine);

        $language = $definition['lang'] ?? 'php';
        $theme = $definition['theme'] ?? 'nord';

        try {
            return $this->shiki->highlightCode($contents, $language, $theme);
        } catch (Exception) {
            return $contents;
        }
    }

    protected function parseLangAndLines(?string $language)
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
            if (strpos($lineNum, '-') === false) {
                $parsed['lines'][intval($lineNum)] = true;

                continue;
            }

            $extremes = explode('-', $lineNum);

            if (count($extremes) !== 2) {
                continue;
            }

            $start = intval($extremes[0]);
            $end = intval($extremes[1]);

            for ($i = $start; $i <= $end; $i++) {
                $parsed['lines'][$i] = true;
            }
        }

        return $parsed;
    }
}
