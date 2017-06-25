<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

/**
 * Class Game
 * @package GOL\GameBundle\Domain
 */
class Game
{
    /** @var null|Board */
    private $board = null;

    /**
     * Game constructor.
     * @param Board $board
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    /**
     * @return null|Board
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * Fill each position of the board.
     */
    public function populateBoard()
    {
        for ($i = 0; $i < $this->board->getWidth(); $i++) {
            for ($j = 0; $j < $this->board->getHeight(); $j++) {
                $this->status[$i][$j] = (bool)rand(0, 1);
            }
        }
    }
}
