<?php

namespace GOL\GameBundle\Test\Integration\Domain;

use GOL\GameBundle\Domain\Board;
use GOL\GameBundle\Domain\Game;
use GOL\GameBundle\Domain\PopulateStrategyPerc;
use GOL\GameBundle\Domain\PopulateStrategyInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class GameTest.
 * @package GOL\GameBundle\Test\Integration\Domain
 */
class GameTest extends TestCase
{
    public function testInitializedGameShouldReturnBoardWithEmptyValues()
    {
        $board = new Board(3, 3);

        /** @var PopulateStrategyInterface $populateStrategy */
        $populateStrategy = new PopulateStrategyPerc();

        $game = new Game($board, $populateStrategy);

        $expected = [
            ['', '', ''],
            ['', '', ''],
            ['', '', ''],
        ];

        $this->assertEquals($expected, $game->getBoard()->getStatus());
    }

    public function testPopulateBoardShouldReturnAnArrayWithNotEmptyValues()
    {
        $board = new Board(3, 3);

        /** @var PopulateStrategyInterface $populateStrategy */
        $populateStrategy = new PopulateStrategyPerc();

        $game = new Game($board, $populateStrategy);

        $game->populateBoard();

        $emptyValues = 0;

        for ($i = 0; $i < $game->getBoard()->getRows(); $i++) {
            for ($j = 0; $j < $game->getBoard()->getColumns(); $j++) {
                if ($game->getBoard()->getStatus()[$i][$j] === '') {
                    $emptyValues++;
                }
            }
        }

        $this->assertSame(0, $emptyValues);
    }

    public function testGenerateCycleWhenNonAliveElementHasExactlyThreeAliveNeighborsShouldReturnThatElementAlive()
    {
        $board = new Board(5, 6);

        /** @var PopulateStrategyInterface $populateStrategy */
        $populateStrategy = new PopulateStrategyPerc();

        $game = new Game($board, $populateStrategy);

        $modifiedBoard = [
            [0, 1, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
            [0, 1, 0, 0, 0, 1],
            [0, 0, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
        ];

        $game->getBoard()->setStatus($modifiedBoard);

        $game->calculateNextLifeCycle();

        // position 0,0 isn't alive and has exactly 3 alive neighbors, therefore should become alive.
        $this->assertSame(1, $game->getBoard()->getStatus()[0][0]);
    }

    public function testGenerateCycleWhenAliveElementHasLessThanTwoAliveNeighborShouldReturnThatElementNoAlive()
    {
        $board = new Board(5, 6);

        /** @var PopulateStrategyInterface $populateStrategy */
        $populateStrategy = new PopulateStrategyPerc();

        $game = new Game($board, $populateStrategy);

        $modifiedBoard = [
            [0, 1, 0, 0, 1, 0],
            [0, 1, 0, 1, 1, 0],
            [0, 0, 0, 0, 0, 1],
            [0, 0, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
        ];

        $game->getBoard()->setStatus($modifiedBoard);

        $game->calculateNextLifeCycle();

        // position 1,1 is alive and has less than 1 alive neighbors, therefore should become not alive.
        $this->assertSame(0, $game->getBoard()->getStatus()[1][1]);
    }

    public function testGenerateCycleWhenAliveElementHasMoreThanThreeAliveNeighborShouldReturnThatElementNoAlive()
    {
        $board = new Board(5, 6);

        /** @var PopulateStrategyInterface $populateStrategy */
        $populateStrategy = new PopulateStrategyPerc();

        $game = new Game($board, $populateStrategy);

        $modifiedBoard = [
            [1, 1, 1, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
            [0, 0, 0, 0, 0, 1],
            [0, 0, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
        ];

        $game->getBoard()->setStatus($modifiedBoard);

        $game->calculateNextLifeCycle();

        // position 1,1 is alive and has more than 3 alive neighbors, therefore should become not alive.
        $this->assertSame(0, $game->getBoard()->getStatus()[1][1]);
    }

    public function testGenerateCycleWhenAliveElementHasTwoAliveNeighborShouldReturnThatElementKeepingBeingAlive()
    {
        $board = new Board(5, 6);

        /** @var PopulateStrategyInterface $populateStrategy */
        $populateStrategy = new PopulateStrategyPerc();

        $game = new Game($board, $populateStrategy);

        $modifiedBoard = [
            [1, 1, 0, 0, 1, 0],
            [0, 1, 0, 1, 1, 0],
            [0, 0, 0, 0, 0, 1],
            [0, 0, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
        ];

        $game->getBoard()->setStatus($modifiedBoard);

        $game->calculateNextLifeCycle();

        // position 0,0 is alive and has exactly 2 alive neighbors, therefore should be alive.
        $this->assertSame(1, $game->getBoard()->getStatus()[0][0]);
    }

    public function testGenerateCycleWhenAliveElementHasThreeAliveNeighborShouldReturnThatElementKeepingBeingAlive()
    {
        $board = new Board(5, 6);

        /** @var PopulateStrategyInterface $populateStrategy */
        $populateStrategy = new PopulateStrategyPerc();

        $game = new Game($board, $populateStrategy);

        $modifiedBoard = [
            [1, 1, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
            [0, 0, 0, 0, 0, 1],
            [0, 0, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
        ];

        $game->getBoard()->setStatus($modifiedBoard);

        $game->calculateNextLifeCycle();

        // position 0,0 is alive and has exactly 3 alive neighbors, therefore should be alive.
        $this->assertSame(1, $game->getBoard()->getStatus()[0][0]);
    }

    public function testGenerateCycleWhenNoAliveElementHasLessThanThreeAliveNeighborShouldReturnThatElementKeepingBeingNoAlive()
    {
        $board = new Board(5, 6);

        /** @var PopulateStrategyInterface $populateStrategy */
        $populateStrategy = new PopulateStrategyPerc();

        $game = new Game($board, $populateStrategy);

        $modifiedBoard = [
            [0, 1, 0, 0, 1, 0],
            [1, 0, 0, 1, 1, 0],
            [0, 0, 0, 0, 0, 1],
            [0, 0, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
        ];

        $game->getBoard()->setStatus($modifiedBoard);

        $game->calculateNextLifeCycle();

        // position 0,0 isn't alive and has less than 3 alive neighbors, therefore should be no alive.
        $this->assertSame(0, $game->getBoard()->getStatus()[0][0]);
    }
}
