<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

class PopulateFiftyPercent implements PopulateStrategyInterface
{
    /**
     * Provide a value for every board element.
     *
     * @link https://goo.gl/JAkrmg
     * Documentation of Probability algorithm
     *
     * @param array $elements
     * @return array
     */
    public function populate(array $elements)
    {
        $power = 2;
        $minValue = 0;
        $maxValue = 1;

        for ($i = 0; $i < count($elements); $i++) {
            for ($j = 0; $j < count($elements); $j++) {
                // lcg_value() returns a random number between 0 and 1
                $elements[$i][$j] = round(0 + ($maxValue - $minValue) * pow(lcg_value(), $power));
            }
        }

        return $elements;
    }
}
