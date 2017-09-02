<?php

namespace ImgDyn;

use InvalidArgumentException;

class Color implements ColorInterface
{

    /**
     * @var int
     */
    private $red;

    /**
     * @var int
     */
    private $green;

    /**
     * @var int
     */
    private $blue;

    /**
     * @var float
     */
    private $alpha;

    /**
     * Create new instance of Color.
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     * @param float $alpha
     * @throws InvalidArgumentException
     */
    public function __construct($red = 0, $green = 0, $blue = 0, $alpha = 1.0)
    {
        if ($red < 0 || $red > 255) {
            throw new InvalidArgumentException('Value "red" must be between 0 and 255');
        }

        if ($green < 0 || $green > 255) {
            throw new InvalidArgumentException('Value "green" must be between 0 and 255');
        }

        if ($blue < 0 || $blue > 255) {
            throw new InvalidArgumentException('Value "blue" must be between 0 and 255');
        }

        if ($alpha < 0 || $alpha > 1) {
            throw new InvalidArgumentException('Value "alpha" must be between 0 and 1');
        }

        $this->red = (int) $red;
        $this->green = (int) $green;
        $this->blue = (int) $blue;
        $this->alpha = (float) $alpha;
    }

    /**
     * Get Red value (0-255)
     *
     * @return int
     */
    public function getRed()
    {
        return $this->red;
    }

    /**
     * Get Green value (0-255)
     *
     * @return int
     */
    public function getGreen()
    {
        return $this->green;
    }

    /**
     * Get Blue value (0-255)
     *
     * @return int
     */
    public function getBlue()
    {
        return $this->blue;
    }

    /**
     * Get Alpha value (0%-100%)
     *
     * @return float
     */
    public function getAlpha()
    {
        return $this->alpha;
    }
}
