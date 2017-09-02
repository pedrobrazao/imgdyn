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
     * @var \ImgDyn\ColorInterface
     */
    private $backgroundColor;

    /**
     * @var int
     */
    private $type;

    /**
     * Create new instance of adapter.
     *
     * @param int $width
     * @param int $height
     * @param ColorInterface $backgroundColor
     * @param int $type
     * @throws InvalidArgumentException
     */
    public function __construct($width, $height, ColorInterface $backgroundColor = null, $type = AdapterInterface::TYPE_PNG)
    {
        if ($width <= 0) {
            throw new InvalidArgumentException('Width of image must be greater than 0.');
        }

        if ($height <= 0) {
            throw new InvalidArgumentException('Height of image must be greater than 0.');
        }

        if (null === $backgroundColor) {
            $backgroundColor = new Color();
        }

        $this->width = (int) $width;
        $this->height = (int) $height;
        $this->backgroundColor = $backgroundColor;

        $this->setType($type);
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
     * Get image height.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set image background color.
     *
     * @param \ImgDyn\ColorInterface $color
     */
    public function setBackgroundColor(ColorInterface $color)
    {
        $this->backgroundColor = $color;

        return $this;
    }

    /**
     * Get image background color.
     *
     * @return \ImgDyn\ColorInterface
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
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
        return $this->type;
    }

    /**
     * Set image type.
     *
     * @param int $type
     */
    public function setType($type)
    {
        if (false === is_int($type)) {
            throw new InvalidArgumentException('Type must be an integer value.');
        }

        $allowed = [
            AdapterInterface::TYPE_JPG,
            AdapterInterface::TYPE_PNG,
            AdapterInterface::TYPE_GIF,
        ];

        if (false === in_array($type, $allowed)) {
            throw new InvalidArgumentException('Invalid type provided.');
        }

        $this->type = $type;

        return $this;
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
