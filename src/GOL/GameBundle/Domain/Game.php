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
     * Populate board first time.
     * @param array $organisms
     * @return array
     */
    public function populateBoard(array $organisms)
    {
        $gameStatus = $this->board->getStatus();
        $boardWidth = count($gameStatus);
        $boardHeight = count($gameStatus[0]);

        for ($i = 0; $i < $boardWidth; $i++) {
            for ($j = 0; $j < $boardHeight; $j++) {

                // set element into a position
                $organism = $organisms[$i][$j];
                $elementStatus = (bool)rand(0, 1);
                $organism->setAlive($elementStatus);
                $gameStatus[$i][$j] = $organism;
            }
        }

        $this->board->setStatus($gameStatus);

        return $this->board->getStatus();
    }

    /**
     * Populate board in each life cycle.
     * @return array
     */
    public function rePopulateBoard()
    {
        $gameStatus = $this->board->getStatus();
        $boardWidth = count($gameStatus);
        $boardHeight = count($gameStatus[0]);

        for ($i = 0; $i < $boardWidth; $i++) {
            for ($j = 0; $j < $boardHeight; $j++) {

                // get status for the new life cycle.
                $positionNextStatus = $this->getPositionNextStatus($i, $j);

                $this->updatePositionStatus($i, $j, $positionNextStatus);
            }
        }

        return $this->board->getStatus();
    }

    /**
     * Update the element value for next life cycle.
     * @param $coordinateX
     * @param $coordinateY
     * @param $nextStatus
     * @return array
     */
    private function updatePositionStatus($coordinateX, $coordinateY, $nextStatus)
    {
        $gameStatus = $this->board->getStatus();

        $gameStatus[$coordinateX][$coordinateY] = $nextStatus;

        $this->board->setStatus($gameStatus);

        return $this->board->getStatus();
    }

    /**
     * Return position value for next life cycle.
     * @param $coordinateX
     * @param $coordinateY
     * @return array|bool
     */
    private function getPositionNextStatus($coordinateX, $coordinateY)
    {
        $aliveNeighbors = $this->getAliveNeighbors($coordinateX, $coordinateY);

        // there is no life in position
        if (!$this->getLifeStatus($coordinateX, $coordinateY)) {
            // alive if 3 alive neighbors
            if ($aliveNeighbors == 3) {
                return true;
            } else {
                return false;
            }
        } else {
            // dead either if alive neighbors < 2 or > 3
            if ($aliveNeighbors < 2 || $aliveNeighbors > 3) {
                return false;
            } else {
                return true;
            }
        }

        return $this->board->getStatus();
    }

    /**
     * Return the number of alive neighbors for a given element.
     * @param $coordinateX
     * @param $coordinateY
     * @param array $organisms|Cell
     * @return int
     */
    private function getAliveNeighbors($coordinateX, $coordinateY)
    {
        $gameStatus = $this->board->getStatus();
        $boardWidth = count($gameStatus);
        $boardHeight = count($gameStatus[0]);

        $aliveNeighbors = 0;
        $aliveNeighborsArray = [];

        for ($x = max(0, $coordinateX - 1); $x <= min($coordinateX + 1, $boardWidth -1); $x++) {
            for ($y = max(0, $coordinateY - 1); $y <= min($coordinateY + 1, $boardHeight -1); $y++) {

                // exclude current position of neighbors counter
                if ($x != $coordinateX || $y != $coordinateY) {

                    // check alive neighbors
//                    if ($this->board->getStatus()[$x][$y] == true) {
                    /** @var Cell */
                    $organism = $this->board->getStatus()[$x][$y];
                    if ($organism->isAlive()) {
                        $aliveNeighbors++;
                        $aliveNeighborsArray[] = "[$x,$y]";
                    }
                }
            }
        }

        return $aliveNeighbors;
    }

    /**
     * Return position status (alive true|false).
     * @param $coordinateX
     * @param $coordinateY
     * @return mixed
     */
    private function getLifeStatus($coordinateX, $coordinateY)
    {
        return $this->board->getStatus()[$coordinateX][$coordinateY];
    }
}
