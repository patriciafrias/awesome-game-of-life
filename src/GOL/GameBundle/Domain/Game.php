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
     */
    public function populateBoard()
    {
        $gameStatus = $this->board->getStatus();

        for ($i = 0; $i < $this->board->getWidth(); $i++) {
            for ($j = 0; $j < $this->board->getHeight(); $j++) {
                $positionStatus = (bool)rand(0, 1);
                $gameStatus[$i][$j] = $positionStatus;
            }
        }

        $this->board->setStatus($gameStatus);

        return $this->board->getStatus();
    }

    /**
     * Populate board in each life cycle.
     */
    public function rePopulateBoard()
    {
        for ($i = 0; $i < $this->board->getWidth(); $i++) {
            for ($j = 0; $j < $this->board->getHeight(); $j++) {

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
     * Return alive neighbors for a given position.
     * @param $coordinateX
     * @param $coordinateY
     * @return int
     */
    private function getAliveNeighbors($coordinateX, $coordinateY)
    {
        $aliveNeighbors = 0;
        $aliveNeighborsArray = [];

        for ($x = max(0, $coordinateX - 1); $x <= min($coordinateX + 1, $this->board->getWidth() -1); $x++) {
            for ($y = max(0, $coordinateY - 1); $y <= min($coordinateY + 1, $this->board->getHeight() -1); $y++) {

                // exclude current position of neighbors counter
                if ($x != $coordinateX || $y != $coordinateY) {

                    // check alive neighbors
                    if ($this->board->getStatus()[$x][$y] == true) {
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
