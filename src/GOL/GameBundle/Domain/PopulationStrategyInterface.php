<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

/**
 * Interface populateStrategyInterface.
 *
 * @package GOL\GameBundle\Domain
 */
interface PopulationStrategyInterface
{
	/**
	 * @param array $elements
	 *
	 * @return mixed
	 */
	public function populate(array $elements);
}
