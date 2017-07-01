<?php

namespace GOL\GameBundle\Test\Integration\Domain;

use GOL\GameBundle\Domain\Board;
use GOL\GameBundle\Domain\Game;
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

        $game = new Game($board);

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

        $game = new Game($board);

        $game->populateBoard();

        $emptyValues = 0;

        for ($i = 0; $i < $game->getBoard()->getWidth(); $i++) {
            for ($j = 0; $j < $game->getBoard()->getHeight(); $j++) {
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

        $game = new Game($board);

        $modifiedBoard = [
            [0, 1, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
            [0, 1, 0, 0, 0, 1],
            [0, 0, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
        ];

        $game->getBoard()->setStatus($modifiedBoard);

        $game->generateCycle();

        // position 0,0 isn't alive and has exactly 3 alive neighbors, therefore should become alive.
        $this->assertSame(1, $game->getBoard()->getStatus()[0][0]);
    }

    public function testGenerateCycleWhenAliveElementHasLessThanTwoAliveNeighborShouldReturnThatElementNoAlive()
    {
        $board = new Board(5, 6);

        $game = new Game($board);

        $modifiedBoard = [
            [0, 1, 0, 0, 1, 0],
            [0, 1, 0, 1, 1, 0],
            [0, 0, 0, 0, 0, 1],
            [0, 0, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
        ];

        $game->getBoard()->setStatus($modifiedBoard);

        $game->generateCycle();

        // position 1,1 is alive and has less than 1 alive neighbors, therefore should become not alive.
        $this->assertSame(0, $game->getBoard()->getStatus()[1][1]);
    }

    public function testGenerateCycleWhenAliveElementHasMoreThanThreeAliveNeighborShouldReturnThatElementNoAlive()
    {
        $board = new Board(5, 6);

        $game = new Game($board);

        $modifiedBoard = [
            [1, 1, 1, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
            [0, 0, 0, 0, 0, 1],
            [0, 0, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
        ];

        $game->getBoard()->setStatus($modifiedBoard);

        $game->generateCycle();

        // position 1,1 is alive and has more than 3 alive neighbors, therefore should become not alive.
        $this->assertSame(0, $game->getBoard()->getStatus()[1][1]);
    }

    public function testGenerateCycleWhenAliveElementHasTwoAliveNeighborShouldReturnThatElementKeepingBeingAlive()
    {
        $board = new Board(5, 6);

        $game = new Game($board);

        $modifiedBoard = [
            [1, 1, 0, 0, 1, 0],
            [0, 1, 0, 1, 1, 0],
            [0, 0, 0, 0, 0, 1],
            [0, 0, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
        ];

        $game->getBoard()->setStatus($modifiedBoard);

        $game->generateCycle();

        // position 0,0 is alive and has exactly 2 alive neighbors, therefore should be alive.
        $this->assertSame(1, $game->getBoard()->getStatus()[0][0]);
    }

    public function testGenerateCycleWhenAliveElementHasThreeAliveNeighborShouldReturnThatElementKeepingBeingAlive()
    {
        $board = new Board(5, 6);

        $game = new Game($board);

        $modifiedBoard = [
            [1, 1, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
            [0, 0, 0, 0, 0, 1],
            [0, 0, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
        ];

        $game->getBoard()->setStatus($modifiedBoard);

        $game->generateCycle();

        // position 0,0 is alive and has exactly 3 alive neighbors, therefore should be alive.
        $this->assertSame(1, $game->getBoard()->getStatus()[0][0]);
    }

    public function testGenerateCycleWhenNoAliveElementHasLessThanThreeAliveNeighborShouldReturnThatElementKeepingBeingNoAlive()
    {
        $board = new Board(5, 6);

        $game = new Game($board);

        $modifiedBoard = [
            [0, 1, 0, 0, 1, 0],
            [1, 0, 0, 1, 1, 0],
            [0, 0, 0, 0, 0, 1],
            [0, 0, 0, 0, 1, 0],
            [1, 1, 0, 1, 1, 0],
        ];

        $game->getBoard()->setStatus($modifiedBoard);

        $game->generateCycle();

        // position 0,0 isn't alive and has less than 3 alive neighbors, therefore should be no alive.
        $this->assertSame(0, $game->getBoard()->getStatus()[0][0]);
    }
}
