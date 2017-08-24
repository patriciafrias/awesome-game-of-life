<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

class PopulateStrategyPerc implements PopulateStrategyInterface
{
    /**
     * Provides a value for every array element.
     *
     * @link https://stackoverflow.com/a/41433648/6102835
     *
     * @param array $elements
     * @return array
     */
    public function populate(array $elements)
    {
        for ($i = 0; $i < count($elements); $i++) {
            for ($j = 0; $j < count($elements); $j++) {
                $elements[$i][$j] = mt_rand(0, 1) == 0 ? mt_rand(0, 1) : rand(0, 1);
            }
        }

        return $elements;
    }
}
