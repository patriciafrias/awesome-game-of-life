<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

/**
 * Class Cell
 * @package GOL\GameBundle\Domain
 */
class Cell
{
    /** @var bool */
    private $alive = false;

    /**
     * @return bool
     */
    public function isAlive(): bool
    {
        return $this->alive;
    }

    /**
     * @param bool $alive
     * @return Cell
     */
    public function setAlive(bool $alive): Cell
    {
        $this->alive = $alive;
        return $this;
    }

}
