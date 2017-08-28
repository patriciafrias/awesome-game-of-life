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
	private $populateStrategyMock = null;

	public function setup()
	{
		$this->boardMock = $this->getMockBuilder(Board::class)
			->disableOriginalConstructor()
			->getMock();

		$this->populateStrategyMock = $this->getMockBuilder(PopulateStrategyInterface::class)
			->disableOriginalConstructor()
			->getMock();
	}

	public function testInitializedGameShouldReturnAnEmptyBoard()
	{
		$this->boardMock->expects($this->once())
			->method('getStatus')
			->willReturn([['', '', '', ''], ['', '', '', ''], ['', '', '', '']]);

		$game = new Game($this->boardMock, $this->populateStrategyMock);

		$this->assertEquals([['', '', '', ''], ['', '', '', ''], ['', '', '', '']], $game->getBoard()->getStatus());
	}

	public function testPopulateGameBoardShouldReturnAnArrayWithFilledPositions()
	{
		$this->populateStrategyMock->expects($this->exactly(1))
			->method('populate')
			->willReturn([[0, 1, 0, 1], [0, 0, 0, 0], [0, 1, 1, 1]]);

		$this->boardMock->expects($this->exactly(3))
			->method('getStatus')
			->willReturn([[0, 1, 1, 1], [0, 0, 1, 1], [1, 0, 1, 1]]);

		$game = new Game($this->boardMock, $this->populateStrategyMock);

		$game->populateBoard();

		$this->assertEquals(0, $game->getBoard()->getStatus()[0][0]);
	}

	public function testCalculateNextLifeCycleGameBoardShouldReturnAnArrayWithModifiedPositions()
	{
		$this->populateStrategyMock->expects($this->exactly(1))
			->method('populate')
			->willReturn([[0, 1, 0, 1], [0, 0, 0, 0], [0, 1, 1, 1]]);

		$this->boardMock->expects($this->exactly(3))
			->method('getStatus')
			->willReturn([[0, 1, 1, 1], [1, 1, 1, 1], [1, 1, 1, 1, 1]]);

		$game = new Game($this->boardMock, $this->populateStrategyMock);

		$game->populateBoard();
		$game->calculateNextLifeCycle();

		// 0,0 position has 3 alive neighbors therefore should be alive
		$this->assertNotEquals([[1, 1, 1, 1], [1, 1, 1, 1], [1, 1, 1, 1, 1]], $game->getBoard()->getStatus());
	}
}
