<?php

namespace ImgDyn;

function imagejpeg($resource, $filename = null, $quality = null)
{
    if (null !== \ImgDynTests\GdAdapterTest::$imagejpegReturns) {
        return \ImgDynTests\GdAdapterTest::$imagejpegReturns;
    }

    return \imagejpeg($resource, $filename, $quality);
}

function imagepng($resource, $filename = null, $quality = null)
{
    if (null !== \ImgDynTests\GdAdapterTest::$imagepngReturns) {
        return \ImgDynTests\GdAdapterTest::$imagepngReturns;
    }

    return \imagepng($resource, $filename, $quality);
}

function imagegif($resource, $filename = null)
{
    if (null !== \ImgDynTests\GdAdapterTest::$imagegifReturns) {
        return \ImgDynTests\GdAdapterTest::$imagegifReturns;
    }

    return \imagegif($resource, $filename);
}

namespace ImgDynTests;

use PHPUnit\Framework\TestCase;

class GdAdapterTest extends TestCase
{

    public static $imagejpegReturns;
    public static $imagepngReturns;
    public static $imagegifReturns;

    protected function tearDown()
    {
        parent::tearDown();

        self::$imagejpegReturns = null;
        self::$imagepngReturns = null;
        self::$imagegifReturns = null;
    }

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

    public function testSaveJpegImage()
    {
        self::$imagejpegReturns = true;
        $adapter = new \ImgDyn\GdAdapter(10, 10);
        $adapter->setType(\ImgDyn\AdapterInterface::TYPE_JPG);

        $this->assertNull($adapter->save('image.jpg'));

        self::$imagejpegReturns = false;
        $this->expectException(\RuntimeException::class);
        $adapter->save('image.jpg');
    }

    public function testSavePngImage()
    {
        self::$imagepngReturns = true;

        $adapter = new \ImgDyn\GdAdapter(10, 10);
        $adapter->setType(\ImgDyn\AdapterInterface::TYPE_PNG);

        $this->assertNull($adapter->save('image.png'));

        self::$imagepngReturns = false;
        $this->expectException(\RuntimeException::class);
        $adapter->save('image.png');
    }

    public function testSaveGifImage()
    {
        self::$imagegifReturns = true;

        $adapter = new \ImgDyn\GdAdapter(10, 10);
        $adapter->setType(\ImgDyn\AdapterInterface::TYPE_GIF);

        $this->assertNull($adapter->save('image.gif'));

        self::$imagegifReturns = false;
        $this->expectException(\RuntimeException::class);
        $adapter->save('image.gif');
    }

    public function testOutputReturnsBase64String()
    {
//        $width = 10;
//        $height = 10;
//
//        $red = $green = $blue = 0;
//        $alpha = 127;
//
//        $resource = imagecreatetruecolor($width, $height);
//        imagecolorallocatealpha($resource, $red, $green, $blue, $alpha);
//
//        ob_start();
//        imagepng($resource);
//        $contents = ob_get_contents();
//        ob_end_clean();
//
//        $expected = base64_encode($contents);
//
//        $backgroundColor = new \ImgDyn\Color($red, $green, $blue, $alpha / 127);
//        $adapter = new \ImgDyn\GdAdapter($width, $height, $backgroundColor, \ImgDyn\AdapterInterface::TYPE_PNG);
//
//        $this->assertEquals($expected, $adapter->output());
    }

}
