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
}
