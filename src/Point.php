<?php

namespace ImgDyn;

class Point implements PointInterface
{

    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * Create new instance of Point.
     *
     * @param int $x
     * @param int $y
     */
    public function __construct($x, $y)
    {
        $this->x = (int) $x;
        $this->y = (int) $y;
    }

    /**
     * Get x-coordinate.
     *
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Get y-coordinate.
     *
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }
}
