<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

/**
 * Class Organism
 * @package GOL\GameBundle\Domain
 */
abstract class OrganismAbstract
{
    /** @var bool */
    protected $alive = false;

    /**
     * @return bool
     */
    public function isAlive(): bool
    {
        return $this->alive;
    }

    /**
     * @param bool $alive
     * @return OrganismAbstract
     */
    public function setAlive(bool $alive): OrganismAbstract
    {
        $this->alive = $alive;
        return $this;
    }

}
