<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

/**
 * Trait ValidBiDimensionalArrayTrait.
 *
 * @package GOL\GameBundle\Domain
 */
trait ValidBiDimensionalArrayTrait
{
	/**
	 * Check if a given array has at least two dimensions.
	 *
	 * rsort() to sort in descending order. This guarantee to check the dimensions of the array only
	 * by the first element.
	 *
	 * @param array $elements
	 *
	 * @return bool
	 */
	public function validateArrayDimensions(array $elements)
	{
		rsort($elements);

		return isset($elements[0]) && is_array($elements[0]);
	}
}
