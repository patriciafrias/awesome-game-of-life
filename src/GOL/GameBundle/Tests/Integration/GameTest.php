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
            ['','',''],
            ['','',''],
            ['','',''],
        ];

        $this->assertEquals($expected, $game->getBoard()->getStatus());
    }
}
