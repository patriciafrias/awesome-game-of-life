<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

class PopulateFiftyPercent implements PopulateStrategyInterface
{
    /**
     * Provide a new value for every element of a given array.
     *
     * @param array $elements
     * @return array
     */
    public function populate(array $elements)
    {
        for ($i = 0; $i < count($elements); $i++) {
            for ($j = 0; $j < count($elements); $j++) {
                // TODO: cambiar al 50%
                $elements[$i][$j] = rand(0, 1);
            }
        }

        return $elements;
    }
}
