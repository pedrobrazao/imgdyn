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

        $newWidth = 20;
        $newHeight = 20;

        $this->assertInstanceOf(\ImgDyn\AdapterInterface::class, $adapter->setWidth($newWidth));
        $this->assertInstanceOf(\ImgDyn\AdapterInterface::class, $adapter->setHeight($newHeight));
        $this->assertEquals($newWidth, $adapter->getWidth());
        $this->assertEquals($newHeight, $adapter->getHeight());
    }

    public function testNegativeWidthRaiseException()
    {
        $adapter = new \ImgDyn\GdAdapter(10, 10);

        $this->expectException(\InvalidArgumentException::class);
        $adapter->setWidth(-1);
    }

    public function testNegativeHeightRaiseException()
    {
        $adapter = new \ImgDyn\GdAdapter(10, 10);

        $this->expectException(\InvalidArgumentException::class);
        $adapter->setHeight(-1);
    }

    public function testBackgroundColorIsOptional()
    {
        $adapter = new \ImgDyn\GdAdapter(10, 10);
        $this->assertInstanceOf(\ImgDyn\ColorInterface::class, $adapter->getBackgroundColor());

        $color = new \ImgDyn\Color(255, 128, 0, .5);
        $adapter->setBackgroundColor($color);
        $this->assertSame($color, $adapter->getBackgroundColor());
    }
}
