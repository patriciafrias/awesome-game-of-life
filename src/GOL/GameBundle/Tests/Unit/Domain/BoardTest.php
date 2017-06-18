<?php

declare(strict_types=1);

namespace GOL\GameBundle\Test\Unit\Domain;

use GOL\GameBundle\Domain\Board;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    /**
     * @dataProvider boardInitProvider
     */
    public function testJustInitializedBoardShouldReturnAnArrayWithoutAliveCells($width, $height, $expected)
    {
        $board = new Board($width, $height);

        $this->assertEquals(
            $expected,
            count($board->getStatus())
        );
    }

    public function testBornCellWhenCellIsDiedShouldReturnAnArrayWithANewAliveCell()
    {
        $board = new Board(5, 5);

        // Make a cell alive
        $board->bornCell(0, 0);

        $boardStatus = $board->getStatus();

        $this->assertSame(1, $boardStatus[0][0]);

    }

    /**
     * @expectedException Exception
     */
    public function testBornCellWhenCellAliveShouldThrowAnException()
    {
        $board = new Board(5, 5);

        // Makes a died cell alive
        $board->bornCell(0, 0);

        // Makes an alive cell alive
        $board->bornCell(0, 0);
    }

    public function boardInitProvider()
    {
        return [
            [4, 4, 4],
//            [8, 8, 8],
//            [16, 16, 16],
//            [32, 32, 32],
//            [64, 64, 64],
        ];
    }
}
