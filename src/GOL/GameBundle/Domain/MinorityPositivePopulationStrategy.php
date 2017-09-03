<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

use GOL\GameBundle\Exception\InvalidInputType;

/**
 * Class MinorityPositivePopulationStrategy.
 *
 * @package GOL\GameBundle\Domain
 */
class MinorityPositivePopulationStrategy implements PopulationStrategyInterface
{
	use ValidBiDimensionalArrayTrait;

	/**
	 * Provides a value for every array element.
	 *
	 * @param array $elements
	 *
	 * @return array
	 * @throws InvalidInputType
	 */
	public function populate(array $elements)
	{
		if (!$this->validateArrayDimensions($elements)) {
			throw new InvalidInputType('Invalid input, it should be an array with two dimensions.');
		}

		for ($i = 0; $i < count($elements); $i++) {
			for ($j = 0; $j < count($elements); $j++) {
				$elements[$i][$j] = mt_rand(0, 1) == 1 ? mt_rand(0, 1) : 0;
			}
		}

		return $elements;
	}
}
