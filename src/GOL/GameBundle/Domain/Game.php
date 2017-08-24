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

    /** @var  PopulateStrategyInterface */
    private $populateStrategy;

    /**
     * @param Board $board
     * @param PopulateStrategyInterface $populateStrategy
     */
    public function __construct(Board $board, PopulateStrategyInterface $populateStrategy)
    {
        $this->board = $board;
        $this->populateStrategy = $populateStrategy;
    }

    /**
     * @return array
     */
    public function populateBoard()
    {
        // TODO: custom exceptions

        $gameStatus = $this->board->getStatus();

        $this->board->setStatus($this->populateStrategy->populate($gameStatus));

        return $this->board->getStatus();
    }

    /**
     * Provides values for the next Life cycle.
     */
    public function calculateNextLifeCycle()
    {
        $newGameStatus = [];

        // Walk through gameStatus.
        for ($i = 0; $i < $this->board->getRows(); $i++) {
            for ($j = 0; $j < $this->board->getColumns(); $j++) {
                // Update element status
                $elementNewStatus = $this->getNextIterationElementStatus($i, $j);
                $newGameStatus[$i][$j] = $elementNewStatus;
            }
        }

        $this->board->setStatus($newGameStatus);
    }

    /**
     * Calculates the number of alive neighbors for a given element.
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

        for ($i = max(0, $coordX - 1); $i <= min($coordX + 1, $this->board->getRows() - 1); $i++) {
            for ($j = max(0, $coordY - 1); $j <= min($coordY + 1, $this->board->getColumns() - 1); $j++) {
                // Exclude current position of neighbors counter
                if ($i != $coordX || $j != $coordY) {
                    // Check alive neighbors
                    if ($gameStatus[$i][$j]) {
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
