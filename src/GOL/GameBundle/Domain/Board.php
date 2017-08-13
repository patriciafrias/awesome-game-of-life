<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain;

/**
 * Class Board
 * @package GOL\GameBundle\Domain
 */
class Board
{
    /** @var int */
    private $columns = 0;

    /** @var int */
    private $rows = 0;

    /** @var array */
    private $status = [];

    /**
     * Board constructor.
     *
     * @param int $rows
     * @param int $columns
     */
    public function __construct(int $rows, int $columns)
    {
        $this->rows = $rows;
        $this->columns = $columns;

        $this->initialize();
    }

    /**
     * Initialize a board with given dimensions.
     */
    protected function initialize()
    {
        for ($i = 0; $i < $this->rows; $i++) {
            $this->status[$i] = [];
            for ($j = 0; $j < $this->columns; $j++) {
                $this->status[$i][$j] = '';
            }
        }
    }

    /**
     * @return array
     */
    public function getStatus(): array
    {
        return $this->status;
    }

    /**
     * @param array $status
     * @return Board
     */
    public function setStatus(array $status): Board
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getColumns(): int
    {
        return $this->columns;
    }

    /**
     * @return int
     */
    public function getRows(): int
    {
        return $this->rows;
    }
}
