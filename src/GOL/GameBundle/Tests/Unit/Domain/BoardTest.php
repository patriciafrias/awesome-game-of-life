<?php

declare(strict_types=1);

namespace GOL\GameBundle\Test\Unit\Domain;

use GOL\GameBundle\Domain\Cell;
use GOL\GameBundle\Domain\Board;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    /**
     * @dataProvider initializeBoardProvider
     */
    public function testJustInitializedBoardShouldReturnAnArrayWithProvidedDimensions($width, $height, $expected)
    {
        $board = new Board($width, $height);

        $this->assertSame(
            $expected,
            count($board->getStatus())
        );
    }

    public function testJustInitializedBoardShouldReturnAnArrayWithNoLivingCells()
    {
        $board = new Board(2, 2);

        /** @var $cell00 Cell */
        $cell00 = $board->getStatus()[0][0];

        /** @var $cell01 Cell */
        $cell01 = $board->getStatus()[0][1];

        /** @var $cell10 Cell */
        $cell10 = $board->getStatus()[1][0];

        /** @var $cell11 Cell */
        $cell11 = $board->getStatus()[1][1];

        // There should be no alive cell in a just initialized board
        $this->assertSame(false, $cell00->isAlive());
        $this->assertSame(false, $cell01->isAlive());
        $this->assertSame(false, $cell10->isAlive());
        $this->assertSame(false, $cell11->isAlive());
    }

//    public function testBornCellWhenCellIsDiedShouldReturnAnArrayWithANewAliveCell()
//    {
//        $board = new Board(5, 5);
//        $cellsArray = $board->getStatus();
//        $cellNeedle = $cellsArray[0][0];

//        print_r($board);
//        print_r($cellNeedle);
//
//        // Make a cell alive
//        $board->bornCell(0, 0);
//
//        $boardStatus = $board->getStatus();
//
//        $this->assertSame(1, $boardStatus[0][0]);

//    }

//    /**
//     * @expectedException Exception
//     */
//    public function testBornCellWhenCellAliveShouldThrowAnException()
//    {
//        $board = new Board(5, 5);
//
//        // Makes a died cell alive
//        $board->bornCell(0, 0);
//
//        // Makes an alive cell alive
//        $board->bornCell(0, 0);
//    }

    public function initializeBoardProvider()
    {
        return [
            [4, 4, 4],
            [8, 8, 8],
            [16, 16, 16],
            [32, 32, 32],
            [64, 64, 64],
        ];
    }
}
