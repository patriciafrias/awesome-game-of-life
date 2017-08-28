<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

trait ValidArrayTrait
{
	/**
	 * Check if a given array has at least two dimensions.
	 * rsort() to sort in descending order. This guarantee to check the dimensions of the array only
	 * by the first element.
	 *
	 * @param array $elements
	 *
	 * @return bool
	 */
	public function validate(array $elements)
	{
		rsort($elements);

		return isset($elements[0]) && is_array($elements[0]);
	}
}
