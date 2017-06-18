<?php

declare(strict_types=1);

namespace GOL\GameBundle\Test\Unit\Domain;

use GOL\GameBundle\Domain\Board;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function testGetStatusShouldReturnAnEmptyArray()
    {
        $board = new Board(4, 4);

        $this->assertEquals([], $board->getStatus());
    }
}