<?php

namespace App\Service;

class Censurator
{
    private array $badWords = [
        'idiot',
        'stupid',
        'shit',
        'fuck',
    ];

    public function purify(string $text): string
    {
        foreach ($this->badWords as $badWord) {
            $pattern = '/\b' . preg_quote($badWord, '/') . '\b/i';
            $replacement = str_repeat('*', mb_strlen($badWord));
            $text = preg_replace($pattern, $replacement, $text);
        }

        return $text;
    }
}
