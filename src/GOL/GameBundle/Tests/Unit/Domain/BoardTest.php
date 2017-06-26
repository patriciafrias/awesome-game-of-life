<?php

declare(strict_types=1);

namespace GOL\GameBundle\Test\Unit\Domain;

use GOL\GameBundle\Domain\OrganismAbstract;
use GOL\GameBundle\Domain\Board;
use PHPUnit\Framework\TestCase;

/**
 * Class BoardTest
 * @package GOL\GameBundle\Test\Unit\Domain
 */
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

//    public function testIterateBoard()
//    {
//        $board = new Board(3, 3);
//
//        $board->iterate();
//
//        $this->assertEquals(true, true);
//    }

}
