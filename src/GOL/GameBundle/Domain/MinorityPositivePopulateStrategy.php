<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

use GOL\GameBundle\Exception\InvalidInputType;

class MinorityPositivePopulateStrategy implements PopulateStrategyInterface
{
	use ValidArrayTrait;

	/**
	 * Provides a value for every array element.
	 *
	 * @param array $elements
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function populate(array $elements)
	{
		if (!$this->validate($elements)) {
			throw new InvalidInputType('Invalid input type, it should be an array.');
		}
		for ($i = 0; $i < count($elements); $i++) {
			for ($j = 0; $j < count($elements); $j++) {
				$elements[$i][$j] = mt_rand(0, 1) == 1 ? mt_rand(0, 1) : 0;
			}
		}

		return $elements;
	}
}
