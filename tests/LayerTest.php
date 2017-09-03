<?php

namespace ImgDynTests;

use PHPUnit\Framework\TestCase;

class LayerTest extends TestCase
{

    public function testCreateLayerWithName()
    {
        $name = 'layer1';
        $layer = new \ImgDyn\Layer($name);

        $this->assertEquals($name, $layer->getName());
        $this->assertInstanceOf(\ImgDyn\PointInterface::class, $layer->getPosition());
    }

    public function testSetName()
    {
        $name = 'layer1';
        $layer = new \ImgDyn\Layer($name);

        $this->assertEquals($name, $layer->getName());

        $newName = 'my layer';
        $layer->setName($newName);

        $this->assertEquals($newName, $layer->getName());
    }

    public function testCreateLayerWithPosition()
    {
        $name = 'layer1';
        $position = new \ImgDyn\Point(10, 10);
        $layer = new \ImgDyn\Layer($name, $position);

        $this->assertEquals($name, $layer->getName());
        $this->assertSame($position, $layer->getPosition());
    }

    public function testSetPosition()
    {
        $name = 'layer1';
        $layer = new \ImgDyn\Layer($name);
        $defaultPosition = $layer->getPosition();

        $this->assertInstanceOf(\ImgDyn\PointInterface::class, $defaultPosition);

        $position = new \ImgDyn\Point(10, 10);
        $layer->setPosition($position);

        $this->assertSame($position, $layer->getPosition());
    }

    public function testCreateLayerWithImage()
    {
        $name = 'layer1';
        $position = new \ImgDyn\Point(10, 10);
        $image = $this->getMockBuilder(\ImgDyn\ImageInterface::class)->getMock();
        $layer = new \ImgDyn\Layer($name, $position, $image);

        $this->assertEquals($name, $layer->getName());
        $this->assertSame($position, $layer->getPosition());
        $this->assertSame($image, $layer->getImage());
    }

    public function testSetImage()
    {
        $name = 'layer1';
        $layer = new \ImgDyn\Layer($name);

        $this->assertNull($layer->getImage());

        $image = $this->getMockBuilder(\ImgDyn\ImageInterface::class)->getMock();
        $layer->setImage($image);

        $this->assertSame($image, $layer->getImage());

        $layer->setImage();
        $this->assertNull($layer->getImage());
    }
}
