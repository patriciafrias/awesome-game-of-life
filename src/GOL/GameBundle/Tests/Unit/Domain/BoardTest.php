<?php

declare(strict_types=1);

namespace GOL\GameBundle\Test\Unit\Domain;

use GOL\GameBundle\Domain\Board;
use PHPUnit\Framework\TestCase;

/**
 * Class BoardTest
 * @package GOL\GameBundle\Test\Unit\Domain
 */
class BoardTest extends TestCase
{
    /**
     * @dataProvider boardConstructorProvider
     */
    public function testBoardConstructor($rows, $columns, $expected)
    {
        $board = new Board($rows, $columns);

        $notEmptyElements = array_filter($board->getStatus(), function ($position) {
            return !in_array("", $position);
        });

        $this->assertEquals($expected, count($notEmptyElements));
    }

    public function boardConstructorProvider()
    {
        return [
            'New Board 3x4 should return an array with empty values'    => [3, 4, 0],
            'New Board 4x6 should return an array with empty values'    => [4, 6, 0],
            'New Board 12x8 should return an array with empty values'   => [12, 8, 0],
            'New Board 50x30 should return an array with empty values'  => [50, 30, 0],
        ];
    }
}
