<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

/**
 * Class Board
 * @package GOL\GameBundle\Domain
 */
class Board
{
    /** @var int */
    private $height = 0;

    /** @var int */
    private $width = 0;

    /** @var array */
    private $status = [];

    /**
     * Board constructor.
     * @param int $gridWidth
     * @param int $gridHeight
     */
    public function __construct(int $gridWidth, int $gridHeight)
    {
        $this->height = $gridHeight;
        $this->width = $gridWidth;
    }

    /**
     * @return array
     */
    public function getStatus(): array
    {
        return $this->status;
    }

    /**
     * @param array $status
     * @return Board
     */
    public function setStatus(array $status): Board
    {
        $this->status = $status;
        return $this;
    }

}