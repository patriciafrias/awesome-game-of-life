<?php

declare(strict_types=1);

namespace GOL\GameBundle\Test\Unit\Domain;

use GOL\GameBundle\Domain\Board;
use GOL\GameBundle\Domain\Cell;
use GOL\GameBundle\Domain\Game;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /** @var PHPUnit_Framework_MockObject_MockObject|Board */
    private $boardMock = null;

    /** @var PHPUnit_Framework_MockObject_MockObject|Cell */
    private $cellMock = null;

    public function setup()
    {
        $this->boardMock = $this->getMockBuilder(Board::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatus', 'populateBoard', 'rePopulateBoard'])
            ->getMock();

        $this->cellMock = $this->getMockBuilder(Cell::class)
            ->disableOriginalConstructor()
            ->setMethods(['isAlive', 'setAlive'])
            ->getMock();
    }

    public function testInitializedGameShouldReturnAnEmptyBoard()
    {
        $this->boardMock->expects($this->once())
            ->method('getStatus')
            ->willReturn([['', '', '', ''], ['', '', '', ''], ['', '', '', '']]);

        $game = new Game($this->boardMock);

        $this->assertEquals([['', '', '', ''], ['', '', '', ''], ['', '', '', '']], $game->getBoard()->getStatus());
    }

    public function testPopulateGameBoardShouldReturnAnArrayWithFilledPositions()
    {
        $this->boardMock->expects($this->exactly(3))
            ->method('getStatus')
            ->willReturn([
                [$this->cellMock, $this->cellMock, $this->cellMock, $this->cellMock],
                [$this->cellMock, $this->cellMock, $this->cellMock, $this->cellMock],
                [$this->cellMock, $this->cellMock, $this->cellMock, $this->cellMock]
            ]);

        $game = new Game($this->boardMock);

        $game->populateBoard($this->cellMock);

        $this->assertEquals([
            [$this->cellMock, $this->cellMock, $this->cellMock, $this->cellMock],
            [$this->cellMock, $this->cellMock, $this->cellMock, $this->cellMock],
            [$this->cellMock, $this->cellMock, $this->cellMock, $this->cellMock]],
            $game->getBoard()->getStatus()
        );
    }

    public function testRePopulateGameBoardShouldReturnAnArrayWithModifiedPositions()
    {
        $this->boardMock->expects($this->exactly(5))
            ->method('getStatus')
            ->willReturn([
                [$this->cellMock, $this->cellMock, $this->cellMock],
                [$this->cellMock, $this->cellMock, $this->cellMock],
                [$this->cellMock, $this->cellMock, $this->cellMock]
            ]);

        $game = new Game($this->boardMock);

        // Cell array to pass to the game based on its board dimensions.
        $cellsArray = [];
        foreach (count($game->getBoard()->getStatus()) as $row) {
            foreach ($row as $column) {
                $cellsArray[$row][$column] = $this->cellMock;
            }
        }

        // pass cells to populate the board (first life cycle)
        $game->populateBoard($cellsArray);

        // pass cells to populate the board (any life cycle)
        $game->rePopulateBoard($game->getBoard()->getStatus());

//        $el00 = $game->getBoard()->getStatus()[0][0]->isAlive(true);

        // 0,0 position has 3 alive neighbors therefore should be alive
        $this->assertEquals(true, $game->getBoard()->getStatus()[0][1]->isAlive());
    }
}
