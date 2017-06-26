<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

/**
 * Class Cell
 * @package GOL\GameBundle\Domain
 */
class Cell extends OrganismAbstract
{
    /** @var string */
    private $color = 'green';

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return Cell
     */
    public function setColor(string $color): Cell
    {
        $this->color = $color;
        return $this;
    }
}
