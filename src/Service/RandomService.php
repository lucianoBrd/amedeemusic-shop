<?php

namespace App\Service;

class RandomService
{
    public function __construct(
    )
    {
    }

    public function getRandom(array $array, int $num): array {
        $length = count($array);

        if ($length == 0 || $length <= $num) {
            return $array;
        }

        return ($num !== 1)
        ? array_values(array_intersect_key($array, array_flip(array_rand($array, $num))))
        : array($array[array_rand($array)]);
    }
}