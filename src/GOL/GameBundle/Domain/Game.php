<?php
declare(strict_types=1);

namespace GOL\GameBundle\Domain;

/**
 * Class Game.
 * @package GOL\GameBundle\Domain
 */
class Game
{
    /** @var Board|null */
    private $board = null;

    /**
     * Game constructor.
     *
     * @param Board $board
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    /**
     * Game board getter.
     *
     * @return Board|null
     */
    public function getBoard()
    {
        return $this->board;
    }
}
