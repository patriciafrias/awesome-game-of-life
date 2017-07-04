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
    public function testJustInitializedBoardShouldReturnAnArrayWithoutLiveCells($width, $height, $expected)
    {
        $board = new Board($width, $height);

        $this->assertEquals(
            $expected,
            count($board->getStatus())
        );
    }

    public function boardInitProvider()
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
