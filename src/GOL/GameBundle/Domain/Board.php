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
     * Makes a cell alive by changing its value 0 to 1.
     * @param $coordinateX
     * @param $coordinateY
     */
    public function bornCell($coordinateX, $coordinateY)
    {
        $this->checkCell($coordinateX, $coordinateY);

        $this->status[$coordinateX][$coordinateY] = 1;
    }

    /**
     * Checks whether if cell exist and
     * @param $x
     * @param $y
     * @throws Exception
     */
    private function checkCell($x, $y)
    {
        if (!isset($this->status[$x][$y])) {
            throw new Exception("Error. Cell doesn't exist.");
        }

        if ($this->status[$x][$y] == 1) {
            throw new Exception("Error. Cell is already alive.");
        }

        $this->status[$x][$y] = 1;
    }

    /**
     * Initializes a board with given dimensions.
     * There is no alive cells, therefore their value is zero (0).
     */
    private function initialize()
    {
        for ($x=0; $x<$this->width; $x++) {
            $this->status[] = [];
            for ($y=0; $y<$this->height; $y++) {
                $this->status[$x][$y] = 0;
            }
        }
    }
}
