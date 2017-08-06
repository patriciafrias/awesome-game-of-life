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
     * Populate each Board element.
     *
     * @return array
     */
    public function populateBoard()
    {
        $gameStatus = $this->board->getStatus();

        // Add a boolean value to each element.
        for ($i = 0; $i < $this->board->getWidth(); $i++) {
            for ($j = 0; $j < $this->board->getHeight(); $j++) {
                $gameStatus[$i][$j] = rand(0, 1);
            }
        }

        $this->board->setStatus($gameStatus);

        return $this->board->getStatus();
    }

    public function calculateNextLifeCycle()
    {
        $newGameStatus = [];

        // Walk through gameStatus.
        for ($i = 0; $i < $this->board->getWidth(); $i++) {
            for ($j = 0; $j < $this->board->getHeight(); $j++) {

                // Update element status (1||0)
                $elementNewStatus = $this->getNextIterationElementStatus($i, $j);
                $newGameStatus[$i][$j] = $elementNewStatus;
            }
        }

        $this->board->setStatus($newGameStatus);
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

        for ($x = max(0, $coordX - 1); $x <= min($coordX + 1, $this->board->getWidth() - 1); $x++) {
            for ($y = max(0, $coordY - 1); $y <= min($coordY + 1, $this->board->getHeight() - 1); $y++) {
                // Exclude current position of neighbors counter
                if ($x != $coordX || $y != $coordY) {
                    // Check alive neighbors
                    if ($gameStatus[$x][$y]) {
                        $aliveNeighbors++;
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
    private function getNextIterationElementStatus($coordX, $coordY)
    {
        $gameStatus = $this->board->getStatus();

        $isElementAlive = $gameStatus[$coordX][$coordY];
        $elementAliveNeighbors = $this->getAliveNeighbors($coordX, $coordY);

        $lifeKeepingNeighborsNumber = in_array($elementAliveNeighbors, [2, 3]);
        $rebirthNeighborsNumber = $elementAliveNeighbors === 3;

        if (($isElementAlive && $lifeKeepingNeighborsNumber) || (!$isElementAlive && $rebirthNeighborsNumber)) {
            $isElementAlive = 1;
        } else {
            $isElementAlive = 0;
        }

        return $isElementAlive;
    }

    /**
     * @return Board|null
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @param Board|null $board
     *
     * @return Game
     */
    public function setBoard($board)
    {
        $this->board = $board;
        return $this;
    }
}
