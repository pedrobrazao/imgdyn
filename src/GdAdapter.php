<?php

namespace ImgDyn;

use InvalidArgumentException;

class GdAdapter implements AdapterInterface
{

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * Create new instance of adapter.
     *
     * @param int $width
     * @param int $height
     * @throws InvalidArgumentException
     */
    public function __construct($width, $height)
    {
        $this->setWidth($width)->setHeight($height);
    }

    /**
     * Set image canvas width.
     *
     * @param int $width
     */
    public function setWidth($width)
    {
        if ($width <= 0) {
            throw new InvalidArgumentException('Width of image must be greater than 0.');
        }

        $this->width = (int) $width;

        return $this;
    }

    /**
     * Get image width.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set image canvas height.
     *
     * @param int $height
     */
    public function setHeight($height)
    {
        if ($height <= 0) {
            throw new InvalidArgumentException('Height of image must be greater than 0.');
        }

        $this->height = (int) $height;

        return $this;
    }

    /**
     * Get image height.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Load the content of a file into the image.
     *
     * @param string $file
     */
    public function load($file)
    {

    }

    /**
     * Optionally save the image to a file and returns its contents encoded as Base64 string.
     *
     * @param string|null $file
     * @return string
     */
    public function save($file = null)
    {

    }

    /**
     * Get image type.
     *
     * @return int
     */
    public function getType()
    {

    }

    /**
     * Set image type.
     *
     * @param int $type
     */
    public function setType($type)
    {

    }

    /**
     * Resize the image dimensions.
     *
     * @param int $width
     * @param int $height
     */
    public function resize($width, $height)
    {

    }

    /**
     * Crop image from one position to another one.
     *
     * @param PointInterface $from
     * @param PointInterface $to
     */
    public function crop(PointInterface $from, PointInterface $to)
    {

    }

}
