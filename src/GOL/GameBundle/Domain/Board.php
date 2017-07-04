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
     *
     * @param int $gridWidth
     * @param int $gridHeight
     */
    public function __construct(int $gridWidth, int $gridHeight)
    {
        $this->height = $gridHeight;
        $this->width = $gridWidth;

        $this->initialize();
    }

    /**
     * Initialize a board with given dimensions.
     */
    protected function initialize()
    {
        for ($x = 0; $x < $this->width; $x++) {
            $this->status[$x] = [];
            for ($y = 0; $y < $this->height; $y++) {
                $this->status[$x][$y] = '';
            }
        }
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

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }
}
