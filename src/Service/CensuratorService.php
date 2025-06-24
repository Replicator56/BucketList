<?php

namespace App\Service;

class CensuratorService
{
    public function purify(string $string) {

        $censuredWords = [
            "bad", "wrong", "beautiful", "good", "pink", "chat"
        ];

        foreach($censuredWords as $word) {
            $replacement = str_repeat('*', mb_strlen($word));
            $string = str_ireplace($word, $replacement, $string);
        }

        return $string;




    }
}
