<?php

namespace ImgDyn;

function extension_loaded($name)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$extensionLoadedReturns) {
        return \ImgDynTests\GdImageLayerTest::$extensionLoadedReturns;
    }

    return \extension_loaded($name);
}

function file_exists($filename)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$fileExistsReturns) {
        return \ImgDynTests\GdImageLayerTest::$fileExistsReturns;
    }

    return \file_exists($filename);
}

function is_readable($filename)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$isReadableReturns) {
        return \ImgDynTests\GdImageLayerTest::$isReadableReturns;
    }

    return \is_readable($filename);
}

function getimagesize($filename)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$getimagesizeReturns) {
        return \ImgDynTests\GdImageLayerTest::$getimagesizeReturns;
    }

    return \getimagesize($filename);
}

function imagecreatefromgif($filename)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$imagecreatefromgifReturns) {
        return \ImgDynTests\GdImageLayerTest::$imagecreatefromgifReturns;
    }

    return \imagecreatefromgif($filename);
}

function imagecreatefromjpeg($filename)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$imagecreatefromjpegReturns) {
        return \ImgDynTests\GdImageLayerTest::$imagecreatefromjpegReturns;
    }

    return \imagecreatefromjpeg($filename);
}

function imagecreatefrompng($filename)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$imagecreatefrompngReturns) {
        return \ImgDynTests\GdImageLayerTest::$imagecreatefrompngReturns;
    }

    return \imagecreatefrompng($filename);
}

function imagejpeg($resource, $filename = null, $quality = null)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$imagejpegReturns) {
        return \ImgDynTests\GdImageLayerTest::$imagejpegReturns;
    }

    return \imagejpeg($resource, $filename, $quality);
}

function imagepng($resource, $filename = null, $quality = null)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$imagepngReturns) {
        return \ImgDynTests\GdImageLayerTest::$imagepngReturns;
    }

    return \imagepng($resource, $filename, $quality);
}

function imagegif($resource, $filename = null)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$imagegifReturns) {
        return \ImgDynTests\GdImageLayerTest::$imagegifReturns;
    }

    return \imagegif($resource, $filename);
}

function imagecreatetruecolor($width, $height)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$imagecreatetruecolorReturns) {
        return \ImgDynTests\GdImageLayerTest::$imagecreatetruecolorReturns;
    }

    return \imagecreatetruecolor($width, $height);
}

function imagecolorallocatealpha($image, $red, $green, $blue, $alpha)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$imagecolorallocatealphaReturns) {
        return \ImgDynTests\GdImageLayerTest::$imagecolorallocatealphaReturns;
    }

    return \imagecolorallocatealpha($image, $red, $green, $blue, $alpha);
}

function imagedestroy($image)
{
    if (null !== \ImgDynTests\GdImageLayerTest::$imagedestroyReturns) {
        return \ImgDynTests\GdImageLayerTest::$imagedestroyReturns;
    }

    return \imagedestroy($image);
}

namespace ImgDynTests;

use PHPUnit\Framework\TestCase;

class GdImageLayerTest extends TestCase
{

    public static $extensionLoadedReturns;
    public static $fileExistsReturns;
    public static $isReadableReturns;
    public static $getimagesizeReturns;
    public static $imagecreatefromgifReturns;
    public static $imagecreatefromjpegReturns;
    public static $imagecreatefrompngReturns;
    public static $imagedestroyReturns;
    public static $imagejpegReturns;
    public static $imagepngReturns;
    public static $imagegifReturns;
    public static $imagecreatetruecolorReturns;
    public static $imagecolorallocatealphaReturns;

    protected function tearDown()
    {
        parent::tearDown();

        self::$extensionLoadedReturns = null;
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
        self::$imagedestroyReturns = null;
    }

    public function testMissingGdExtensionRaiseExceptions()
    {
        self::$extensionLoadedReturns = false;

        $this->expectException(\RuntimeException::class);
        new \ImgDyn\GdImageLayer('path/to/file');
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
        self::$imagedestroyReturns = true;

        $image = new \ImgDyn\GdImageLayer('path/to/image');

        $this->assertEquals(self::$getimagesizeReturns[0], $image->getWidth());
        $this->assertEquals(self::$getimagesizeReturns[1], $image->getHeight());
        $this->assertEquals(self::$getimagesizeReturns[2], $image->getType());
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
        new \ImgDyn\GdImageLayer('path/to/image');
    }

    public function testNonImageFileRaiseException()
    {
        self::$fileExistsReturns = true;
        self::$isReadableReturns = true;
        self::$getimagesizeReturns = false;

        $this->expectException(\InvalidArgumentException::class);
        new \ImgDyn\GdImageLayer('path/to/image');
    }

    public function testUnsupportedImageTypeRaiseException()
    {
        self::$fileExistsReturns = true;
        self::$isReadableReturns = true;
        self::$getimagesizeReturns = [640, 480, 99];

        $this->expectException(\InvalidArgumentException::class);
        new \ImgDyn\GdImageLayer('path/to/image');
    }

    public function testCreateImageFailureRaiseException()
    {
        self::$fileExistsReturns = true;
        self::$isReadableReturns = true;
        self::$getimagesizeReturns = [640, 480, IMAGETYPE_PNG];
        self::$imagecreatefrompngReturns = false;

        $this->expectException(\RuntimeException::class);
        new \ImgDyn\GdImageLayer('path/to/image');
    }

    public function testCreateEmptyImage()
    {
        $width = 100;
        $height = 100;
        $type = IMAGETYPE_PNG;

        $image = new \ImgDyn\GdImageLayer(null, $width, $height, $type);

        $this->assertEquals($width, $image->getWidth());
        $this->assertEquals($height, $image->getHeight());
        $this->assertEquals($type, $image->getType());
    }

    public function testCreateEmptyImageWithBadWidthRaiseException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new \ImgDyn\GdImageLayer(null, 0);
    }

    public function testCreateEmptyImageWithBadHeightRaiseException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new \ImgDyn\GdImageLayer(null, 100, 0);
    }

    public function testClone()
    {
        $layer = new \ImgDyn\GdImageLayer(null, 10, 10);
        $image = new \ImgDyn\GdImageLayer(null, 10, 10);
        $image->addLayer($layer, 'layer1');

        $clone = clone $image;

        $this->assertInstanceOf(\ImgDyn\GdImageLayer::class, $clone);
        $this->assertEquals(1, count($clone->getLayers()));
    }

    /**
     * @dataProvider getContentsProvider
     * @param int $type
     */
    public function testGetContents($type)
    {
        $image = new \ImgDyn\GdImageLayer(null, 10, 10, $type);
        $this->assertTrue(is_string($image->getContents()));
    }

    public function getContentsProvider()
    {
        return [
            [IMAGETYPE_GIF],
            [IMAGETYPE_JPEG],
            [IMAGETYPE_PNG],
        ];
    }

    public function testGetContentsRaiseExceptionOnOutputFailure()
    {
        self::$imagepngReturns = false;

        $image = new \ImgDyn\GdImageLayer(null, 10, 10, IMAGETYPE_PNG);

        $this->expectException(\RuntimeException::class);
        $image->getContents();
    }

    public function testMerge()
    {
        $image = new \ImgDyn\GdImageLayer(null, 10, 10);
        $image->addLayer(new \ImgDyn\GdImageLayer(null, 10, 10), 'layer1');

        $this->assertEquals(1, count($image->getLayers()));

        $image->merge();
        $this->assertEquals(0, count($image->getLayers()));
    }
}
