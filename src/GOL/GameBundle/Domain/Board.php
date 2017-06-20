<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

use Exception;

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
     * Initializes a board with given dimensions.
     * There is no alive cells, therefore their value is zero (0).
     */
    private function initialize()
    {
        for ($x = 0; $x < $this->width; $x++) {
            $this->status[] = [];
            for ($y = 0; $y < $this->height; $y++) {
                $this->status[$x][$y] = new Cell();
            }
        }
    }

    /**
     * Updates a position with the new cell status.
     * @param Cell $cell
     * @param bool $newStatus
     */
    private function update(Cell $cell, bool $newStatus)
    {
        // TODO: code to update Board
    }

    /**
     * Gets the adjacent elements to a given position cell.
     */
    private function getAdjacent()
    {
        // TODO: code to check adjacent elements to a given cell position.
    }

    public function iterate()
    {
        // TODO: code to iterate a board
        // use a helper to call this function many times.
    }

//    /**
//     * Makes a cell alive by changing its value 0 to 1.
//     * @param $coordinateX
//     * @param $coordinateY
//     */
//    public function bornCell($coordinateX, $coordinateY)
//    {
//        $this->validateCell($coordinateX, $coordinateY);
//
//        if (!$this->isAliveCell($coordinateX, $coordinateY)) {
//            $this->status[$coordinateX][$coordinateY] = 1;
//        }
//    }

//    /**
//     * Checks if cell exists.
//     * @param $x
//     * @param $y
//     * @throws Exception
//     */
//    private function validateCell($x, $y)
//    {
//        if (!isset($this->status[$x][$y])) {
//            throw new Exception("Error. Cell doesn't exist.");
//        }
//    }

//    /**
//     * Checks if a given cell is alive.
//     * @param $x
//     * @param $y
//     * @throws Exception
//     */
//    private function isAliveCell($x, $y)
//    {
//        if ($this->status[$x][$y] == 1) {
//            throw new Exception("Error. Cell is already alive.");
//        }
//    }


}
