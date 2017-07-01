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

    /**
     *Game board setter.
     *
     * @param Board|null $board
     *
     * @return Game
     */
    public function setBoard($board)
    {
        $this->board = $board;
        return $this;
    }

    /**
     * Calculate the number of alive neighbors for a given element.
     *
     * @param $coordX
     * @param $coordY
     *
     * @return int
     */
    private function getAliveNeighbors($coordX, $coordY)
    {
        $gameStatus = $this->board->getStatus();
        $aliveNeighbors = 0;
        $aliveNeighborsArray = [];

        for ($x = max(0, $coordX - 1); $x <= min($coordX + 1, $this->board->getWidth() - 1); $x++) {
            for ($y = max(0, $coordY - 1); $y <= min($coordY + 1, $this->board->getHeight() - 1); $y++) {
                // exclude current position of neighbors counter
                if ($x != $coordX || $y != $coordY) {
                    // check alive neighbors
                    if ($gameStatus[$x][$y]) {
                        $aliveNeighbors++;
                        $aliveNeighborsArray[] = "[$x,$y]";
                    }
                }
            }
        }

        return $aliveNeighbors;
    }

    /**
     * Calculate a new status for a given element.
     *
     * @param $coordX
     * @param $coordY
     *
     * @return int|null
     */
    private function setElementNextStatus($coordX, $coordY)
    {
        $gameStatus = $this->board->getStatus();
        $aliveNeighbors = $this->getAliveNeighbors($coordX, $coordY);
        $elementCurrentStatus = $gameStatus[$coordX][$coordY];
        $elementNewStatus = null;

        // if element isn't alive
        if (!$elementCurrentStatus) {
            if ($aliveNeighbors === 3) {
                // alive is true (nace)
                $elementNewStatus = 1;
            } else {
                // alive is false (keep died)
                $elementNewStatus = 0;
            }
        } else {
            if ($aliveNeighbors < 2 || $aliveNeighbors > 3) {
                // alive is false
                $elementNewStatus = 0;
            } else {
                // alive is true
                $elementNewStatus = 1;
            }
        }

        return $elementNewStatus;
    }

    /**
     * Populate each Board element.
     *
     * @return array
     */
    public function populateBoard()
    {
        $gameStatus = $this->board->getStatus();

        // add a boolean value to each element.
        for ($i = 0; $i < $this->board->getWidth(); $i++) {
            for ($j = 0; $j < $this->board->getHeight(); $j++) {
                $gameStatus[$i][$j] = (bool)rand(0, 1);
            }
        }

        $this->board->setStatus($gameStatus);

        return $this->board->getStatus();
    }

    public function generateCycle()
    {
        $newGameStatus = [];

        // walk through gameStatus.
        for ($i = 0; $i < $this->board->getWidth(); $i++) {
            for ($j = 0; $j < $this->board->getHeight(); $j++) {

                // update element status (alive true or false)
                $elementNewStatus = $this->setElementNextStatus($i, $j);
                $newGameStatus[$i][$j] = $elementNewStatus;
            }
        }

        $this->board->setStatus($newGameStatus);
    }
}
