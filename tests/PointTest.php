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
}
