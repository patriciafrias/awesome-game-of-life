<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

/**
 * Interface populateStrategyInterface
 *
 * @package GOL\GameBundle\Domain
 */
interface PopulateStrategyInterface
{
    public function populate(array $elements);
}
