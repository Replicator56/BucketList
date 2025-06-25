<?php

namespace App\Service;

class CensuratorService
{
    private const CENSURE_WORDS = [
        "bad", "wrong", "beautiful", "good", "pink", "chat"
    ];

    /**
     * Method purify allows to censure a sentence
     * @param string $string
     * @return array|string|string[]
     */
    public function purify(string $string) {

        foreach(static::CENSURE_WORDS as $word) {
            $replacement = str_repeat('*', mb_strlen($word));
            $string = str_ireplace($word, $replacement, $string);
        }

        return $string;
    }
}
