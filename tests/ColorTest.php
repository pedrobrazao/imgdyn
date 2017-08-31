<?php

namespace ImgDynTests;

use PHPUnit\Framework\TestCase;

class ColorTest extends Testcase
{

    public function testgetRed()
    {

        $red = 128;
        $green = 128;
        $blue = 234;
        $alpha = 1;

        $color = new \ImgDyn\Color($red);

        $this->assertEquals($red, $color->getRed());
    }

    public function testgetGreen()
    {

        $red = 255;
        $green = 1;
        $blue = 234;
        $alpha = 1;

        $color = new \ImgDyn\Color($red, $green);

        $this->assertEquals($green, $color->getGreen());
    }

    public function testgetBlue()
    {

        $red = 255;
        $green = 1;
        $blue = 234;
        $alpha = 1;

        $color = new \ImgDyn\Color($red, $green, $blue);

        $this->assertEquals($blue, $color->getBlue());
    }

    public function testgetAlpha()
    {

        $red = 255;
        $green = 1;
        $blue = 234;
        $alpha = 1;

        $color = new \ImgDyn\Color($red, $green, $blue, $alpha);

        $this->assertEquals($alpha, $color->getAlpha());
    }

    public function testConstructRaisesExceptionOnInvalidXred()
    {
        $red = 256;
        $green = 255;
        $blue = 255;
        $alpha = 1;

        $this->expectException(\InvalidArgumentException::class);
        $color = new \ImgDyn\Color($red, $green, $blue, $alpha);
    }

    public function testConstructRaisesExceptionOnInvalidXgreen()
    {
        $red = 255;
        $green = 256;
        $blue = 255;
        $alpha = 1;

        $this->expectException(\InvalidArgumentException::class);
        $color = new \ImgDyn\Color($red, $green, $blue, $alpha);
    }

    public function testConstructRaisesExceptionOnInvalidXblue()
    {
        $red = 255;
        $green = 255;
        $blue = 256;
        $alpha = 1;

        $this->expectException(\InvalidArgumentException::class);
        $color = new \ImgDyn\Color($red, $green, $blue, $alpha);
    }

    public function testConstructRaisesExceptionOnInvalidXalpha()
    {
        $red = 255;
        $green = 255;
        $blue = 255;
        $alpha = 2;

        $this->expectException(\InvalidArgumentException::class);
        $color = new \ImgDyn\Color($red, $green, $blue, $alpha);
    }
}
