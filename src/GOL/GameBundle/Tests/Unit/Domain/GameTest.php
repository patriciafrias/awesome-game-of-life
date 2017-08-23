<?php

declare(strict_types=1);

namespace GOL\GameBundle\Test\Unit\Domain;

use GOL\GameBundle\Domain\Board;
use GOL\GameBundle\Domain\Game;
use GOL\GameBundle\Domain\PopulateStrategyInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class GameTest
 * @package GOL\GameBundle\Test\Unit\Domain
 */
class GameTest extends TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|Board */
    private $boardMock = null;

    /** @var \PHPUnit_Framework_MockObject_MockObject|PopulateStrategyInterface */
    private $populateStrategy = null;

    public function setup()
    {
        $this->boardMock = $this->getMockBuilder(Board::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->populateStrategy = $this->getMockBuilder(PopulateStrategyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testInitializedGameShouldReturnAnEmptyBoard()
    {
        $this->boardMock->expects($this->once())
            ->method('getStatus')
            ->willReturn([['', '', '', ''], ['', '', '', ''], ['', '', '', '']]);

        $game = new Game($this->boardMock, $this->populateStrategy);

        $this->assertEquals([['', '', '', ''], ['', '', '', ''], ['', '', '', '']], $game->getBoard()->getStatus());
    }

    /**
     * @covers Game::populateBoard
     */
    public function testPopulateGameBoardShouldReturnAnArrayWithFilledPositions()
    {
        $this->boardMock->expects($this->exactly(3))
            ->method('getStatus')
            ->willReturn([['0', '1', '1', '1'], ['0', '0', '1', '1'], ['1', '0', '1', '1']]);

        $game = new Game($this->boardMock, $this->populateStrategy);

        $game->populateBoard();

        $this->assertEquals(0, $game->getBoard()->getStatus()[0][0]);
    }

    /**
     * @covers Game::populateBoard
     * @covers Game::calculateNextLifeCycle
     */
    public function testCalculateNextLifeCycleGameBoardShouldReturnAnArrayWithModifiedPositions()
    {
        $this->boardMock->expects($this->exactly(3))
            ->method('getStatus')
            ->willReturn([[0, 1, 1, 1], [1, 1, 1, 1], [1, 1, 1, 1, 1]]);

        $game = new Game($this->boardMock, $this->populateStrategy);

        $game->populateBoard();
        $game->calculateNextLifeCycle();

        // 0,0 position has 3 alive neighbors therefore should be alive
        $this->assertNotEquals([[1, 1, 1, 1], [1, 1, 1, 1], [1, 1, 1, 1, 1]], $game->getBoard()->getStatus());
    }
}
