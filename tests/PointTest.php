<?php

namespace ImgDynTests;

use PHPUnit\Framework\TestCase;

class PointTest extends TestCase
{

    public function testGetX()
    {
        $x = 0;
        $y = 0;

        $point = new \ImgDyn\Point($x, $y);

        $this->assertEquals($x, $point->getX());
    }

    public function testGetY()
    {
        $x = 0;
        $y = 0;

        $point = new \ImgDyn\Point($x, $y);

        $this->assertEquals($y, $point->getY());
    }

    public function testConstructRaisesExceptionOnInvalidX()
    {
        $x = -1;
        $y = 0;

        $this->expectException(\InvalidArgumentException::class);
        $point = new \ImgDyn\Point($x, $y);
    }

    public function testConstructRaisesExceptionOnInvalidY()
    {
        $x = 0;
        $y = -1;

        $this->expectException(\InvalidArgumentException::class);
        $point = new \ImgDyn\Point($x, $y);
    }
}
