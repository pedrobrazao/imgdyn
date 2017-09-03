<?php

namespace ImgDyn;

function file_exists($filename)
{
    if (null !== \ImgDynTests\GdAdapterTest::$fileExistsReturns) {
        return \ImgDynTests\GdAdapterTest::$fileExistsReturns;
    }

    return \file_exists($filename);
}

function is_readable($filename)
{
    if (null !== \ImgDynTests\GdAdapterTest::$isReadableReturns) {
        return \ImgDynTests\GdAdapterTest::$isReadableReturns;
    }

    return \is_readable($filename);
}

function getimagesize($filename)
{
    if (null !== \ImgDynTests\GdAdapterTest::$getimagesizeReturns) {
        return \ImgDynTests\GdAdapterTest::$getimagesizeReturns;
    }

    return \getimagesize($filename);
}

function imagecreatefromgif($filename)
{
    if (null !== \ImgDynTests\GdAdapterTest::$imagecreatefromgifReturns) {
        return \ImgDynTests\GdAdapterTest::$imagecreatefromgifReturns;
    }

    return \imagecreatefromgif($filename);
}

function imagecreatefromjpeg($filename)
{
    if (null !== \ImgDynTests\GdAdapterTest::$imagecreatefromjpegReturns) {
        return \ImgDynTests\GdAdapterTest::$imagecreatefromjpegReturns;
    }

    return \imagecreatefromjpeg($filename);
}

function imagecreatefrompng($filename)
{
    if (null !== \ImgDynTests\GdAdapterTest::$imagecreatefrompngReturns) {
        return \ImgDynTests\GdAdapterTest::$imagecreatefrompngReturns;
    }

    return \imagecreatefrompng($filename);
}

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

function imagecreatetruecolor($width, $height)
{
    if (null !== \ImgDynTests\GdAdapterTest::$imagecreatetruecolorReturns) {
        return \ImgDynTests\GdAdapterTest::$imagecreatetruecolorReturns;
    }

    return \imagecreatetruecolor($width, $height);
}

function imagecolorallocatealpha($image, $red, $green, $blue, $alpha)
{
    if (null !== \ImgDynTests\GdAdapterTest::$imagecolorallocatealphaReturns) {
        return \ImgDynTests\GdAdapterTest::$imagecolorallocatealphaReturns;
    }

    return \imagecolorallocatealpha($image, $red, $green, $blue, $alpha);
}

namespace ImgDynTests;

use PHPUnit\Framework\TestCase;

class GdAdapterTest extends TestCase
{

    public static $fileExistsReturns;
    public static $isReadableReturns;
    public static $getimagesizeReturns;
    public static $imagecreatefromgifReturns;
    public static $imagecreatefromjpegReturns;
    public static $imagecreatefrompngReturns;
    public static $imagejpegReturns;
    public static $imagepngReturns;
    public static $imagegifReturns;
    public static $imagecreatetruecolorReturns;
    public static $imagecolorallocatealphaReturns;

    protected function tearDown()
    {
        parent::tearDown();

        self::$fileExistsReturns = null;
        self::$isReadableReturns = null;
        self::$getimagesizeReturns = null;
        self::$imagecreatefromgifReturns = null;
        self::$imagecreatefromjpegReturns = null;
        self::$imagecreatefrompngReturns = null;
        self::$imagejpegReturns = null;
        self::$imagepngReturns = null;
        self::$imagegifReturns = null;
        self::$imagecreatetruecolorReturns = null;
        self::$imagecolorallocatealphaReturns = null;
    }

    /**
     * @dataProvider constructProvider
     * @param int $width
     * @param int $height
     * @param int $type
     */
    public function testCreateImageFromFile($width, $height, $type)
    {
        self::$fileExistsReturns = true;
        self::$isReadableReturns = true;
        self::$getimagesizeReturns = [$width, $height, $type];
        self::$imagecreatefromgifReturns = fopen('php://stdout', 'r');
        self::$imagecreatefromjpegReturns = fopen('php://stdout', 'r');
        self::$imagecreatefrompngReturns = fopen('php://stdout', 'r');

        $adapter = new \ImgDyn\GdAdapter('path/to/image');

        $this->assertEquals(self::$getimagesizeReturns[0], $adapter->getWidth());
        $this->assertEquals(self::$getimagesizeReturns[1], $adapter->getHeight());
        $this->assertEquals(self::$getimagesizeReturns[2], $adapter->getType());
    }

    public function constructProvider()
    {
        return [
            [rand(100, 300), rand(100, 300), IMAGETYPE_GIF],
            [rand(100, 300), rand(100, 300), IMAGETYPE_JPEG],
            [rand(100, 300), rand(100, 300), IMAGETYPE_PNG],
        ];
    }

    public function testNotFoundFileRaiseException()
    {
        self::$fileExistsReturns = false;

        $this->expectException(\InvalidArgumentException::class);
        new \ImgDyn\GdAdapter('path/to/image');
    }

    public function testNonImageFileRaiseException()
    {
        self::$fileExistsReturns = true;
        self::$isReadableReturns = true;
        self::$getimagesizeReturns = false;

        $this->expectException(\InvalidArgumentException::class);
        new \ImgDyn\GdAdapter('path/to/image');
    }

    public function testUnsupportedImageTypeRaiseException()
    {
        self::$fileExistsReturns = true;
        self::$isReadableReturns = true;
        self::$getimagesizeReturns = [640, 480, 99];

        $this->expectException(\InvalidArgumentException::class);
        new \ImgDyn\GdAdapter('path/to/image');
    }

    public function testCreateImageFailureRaiseException()
    {
        self::$fileExistsReturns = true;
        self::$isReadableReturns = true;
        self::$getimagesizeReturns = [640, 480, IMAGETYPE_PNG];
        self::$imagecreatefrompngReturns = false;

        $this->expectException(\RuntimeException::class);
        new \ImgDyn\GdAdapter('path/to/image');
    }

    public function testCreateEmptyImage()
    {
        $width = rand(100, 300);
        $height= rand(100, 300);
        $type = IMAGETYPE_PNG;
        $backgroundColor = new \ImgDyn\Color();

        $adapter = new \ImgDyn\GdAdapter(null, $width, $height, $type, $backgroundColor);

        $this->assertEquals($width, $adapter->getWidth());
        $this->assertEquals($height, $adapter->getHeight());
        $this->assertEquals($type, $adapter->getType());
        $this->assertSame($backgroundColor, $adapter->getBackgroundColor());
    }

    public function testCreateEmptyImageWithBadWidthRaiseException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new \ImgDyn\GdAdapter(null, 0);
    }

    public function testCreateEmptyImageWithBadHeightRaiseException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new \ImgDyn\GdAdapter(null, 100, 0);
    }

    public function testCreateEmptyImageWithUnsupportedTypeRaiseException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new \ImgDyn\GdAdapter(null, 100, 100, 99);
    }

    public function testCreateEmptyImageTypeDefaultsToPng()
    {
        $adapter = new \ImgDyn\GdAdapter(null, 100, 100);
        $this->assertEquals(IMAGETYPE_PNG, $adapter->getType());
    }

    public function testCreateEmptyImageTypeDefaultsToInstanceOfColor()
    {
        $adapter = new \ImgDyn\GdAdapter(null, 100, 100);
        $this->assertInstanceOf(\ImgDyn\ColorInterface::class, $adapter->getBackgroundColor());
    }

    public function testSetBackgroundColor()
    {
        $adapter = new \ImgDyn\GdAdapter(null, 100, 100);

        $color = new \ImgDyn\Color();
        $adapter->setBackgroundColor($color);

        $this->assertSame($color, $adapter->getBackgroundColor());
    }

    /**
     * @dataProvider testSaveProvider
     * @param int $type
     */
    public function testSave($type)
    {
        $width = rand(1, 20);
        $height = rand(1, 20);

        $file = tempnam(sys_get_temp_dir(), 'img');

        $adapter = new \ImgDyn\GdAdapter(null, $width, $height, $type);
        $adapter->save($file);

        $size = filesize($file);
        $info = getimagesize($file);
        $contents = file_get_contents($file);
        unlink($file);

        $this->assertGreaterThan(0, $size);
        $this->assertTrue(is_array($info));

        $this->assertEquals($width, $info[0]);
        $this->assertEquals($height, $info[1]);
        $this->assertEquals($type, $info[2]);

        $this->assertEquals($size, $adapter->getSize());
        $this->assertEquals(base64_encode($contents), $adapter->output());
    }

    public function testSaveProvider()
    {
        return [
            [IMAGETYPE_GIF],
            [IMAGETYPE_JPEG],
            [IMAGETYPE_PNG],
        ];
    }

    public function testExport()
    {
        $adapter = new \ImgDyn\GdAdapter(null, 10, 10, IMAGETYPE_GIF);

        $this->assertEquals(IMAGETYPE_GIF, $adapter->getType());

        $adapter->export(IMAGETYPE_JPEG);
        $this->assertEquals(IMAGETYPE_JPEG, $adapter->getType());
    }

    public function testResize()
    {
        $width = rand(10, 50);
        $height = rand(10, 50);

        $adapter = new \ImgDyn\GdAdapter(null, $width, $height);

        $this->assertEquals($width, $adapter->getWidth());
        $this->assertEquals($height, $adapter->getHeight());

        $newWidth = rand(10, 50);
        $newHeight = rand(10, 50);

        $adapter->resize($newWidth, $newHeight);

        $this->assertEquals($newWidth, $adapter->getWidth());
        $this->assertEquals($newHeight, $adapter->getHeight());
    }

    public function testCrop()
    {
        $width = 320;
        $height = 240;

        $adapter = new \ImgDyn\GdAdapter(null, $width, $height);

        $this->assertEquals($width, $adapter->getWidth());
        $this->assertEquals($height, $adapter->getHeight());

        $from = new \ImgDyn\Point(10, 10);
        $to = new \ImgDyn\Point(90, 50);

        $newWidth = $to->getX() - $from->getX();
        $newHeight = $to->getY() - $from->getY();
        ;

        $adapter->crop($from, $to);

        $this->assertEquals($newWidth, $adapter->getWidth());
        $this->assertEquals($newHeight, $adapter->getHeight());
    }
}
