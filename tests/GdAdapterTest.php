<?php

namespace ImgDynTests;

use PHPUnit\Framework\TestCase;

class GdAdapterTest extends TestCase
{

    public function testSetAndGetCanvasDimensions()
    {
        $width = 10;
        $height = 10;

        $adapter = new \ImgDyn\GdAdapter($width, $height);

        $this->assertEquals($width, $adapter->getWidth());
        $this->assertEquals($height, $adapter->getHeight());
    }

    public function testNegativeWidthRaiseException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new \ImgDyn\GdAdapter(-1, 10);
    }

    public function testNegativeHeightRaiseException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new \ImgDyn\GdAdapter(10, -1);
    }

    public function testBackgroundColorIsOptional()
    {
        $adapter = new \ImgDyn\GdAdapter(10, 10);
        $this->assertInstanceOf(\ImgDyn\ColorInterface::class, $adapter->getBackgroundColor());

        $color = new \ImgDyn\Color(255, 128, 0, .5);
        $adapter->setBackgroundColor($color);
        $this->assertSame($color, $adapter->getBackgroundColor());
    }

    public function testTypeIsOptional()
    {
        $adapter = new \ImgDyn\GdAdapter(10, 10);
        $this->assertTrue(is_int($adapter->getType()));

        $type = \ImgDyn\AdapterInterface::TYPE_GIF;
        $adapter->setType($type);
        $this->assertSame($type, $adapter->getType());
    }

    public function testBadTypeValueRaisesException()
    {
        $adapter = new \ImgDyn\GdAdapter(10, 10);
        $this->expectException(\InvalidArgumentException::class);
        $adapter->setType('png');
    }

    public function testUnsupportedTypeRaisesException()
    {
        $adapter = new \ImgDyn\GdAdapter(10, 10);
        $this->expectException(\InvalidArgumentException::class);
        $adapter->setType(0);
    }

}
