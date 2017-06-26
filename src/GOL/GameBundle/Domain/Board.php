<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

/**
 * Class Board with a given dimensions
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

        $this->initialize();
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

    /**
     * Initializes a board with given dimensions.
     */
    private function initialize()
    {
        for ($i = 0; $i < $this->width; $i++) {
            $this->status[] = [];
            for ($j = 0; $j < $this->height; $j++) {
                $this->status[$i][$j] = '';
            }
        }
    }
}
