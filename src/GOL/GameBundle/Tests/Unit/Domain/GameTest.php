<?php

declare(strict_types=1);

namespace GOL\GameBundle\Test\Unit\Domain;

use GOL\GameBundle\Domain\Board;
use GOL\GameBundle\Domain\Game;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

class GameTest extends TestCase
{
    /** @var PHPUnit_Framework_MockObject_MockObject|Board */
    private $boardMock = null;

    public function setup()
    {
        $this->boardMock = $this->getMockBuilder(Board::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatus', 'populateBoard'])
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
            ->willReturn([['false', 'true', 'true', 'true'], ['true', 'true', 'true', 'true'], ['true', 'true', 'true', 'true']]);

        $game = new Game($this->boardMock);
        $game->populateBoard();

        $this->assertEquals([['false', 'true', 'true', 'true'], ['true', 'true', 'true', 'true'], ['true', 'true', 'true', 'true']], $game->getBoard()->getStatus());
    }

    public function testRePopulateGameBoardShouldReturnAnArrayWithModifiedPositions()
    {
        $this->boardMock->expects($this->exactly(4))
            ->method('getStatus')
            ->willReturn([['false', 'true', 'true', 'true'], ['true', 'true', 'true', 'true'], ['true', 'true', 'true', 'true']]);

        $game = new Game($this->boardMock);

        $game->populateBoard();

        $game->rePopulateBoard();

        // 0,0 position has 3 alive neighbors therefore should be alive
        $this->assertNotEquals([['true', 'true', 'true', 'true'], ['true', 'true', 'true', 'true'], ['true', 'true', 'true', 'true']], $game->getBoard()->getStatus());
    }

}
