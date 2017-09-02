<?php

namespace ImgDyn;

use InvalidArgumentException;
use RuntimeException;

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
     * @var resource
     */
    private $resource;

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
     * Get image resource.
     *
     * @return resource
     * @throws RuntimeException
     */
    protected function getResource()
    {
        if (null === $this->resource) {
            if (false === $this->resource = imagecreatetruecolor($this->width, $this->height)) {
                throw new RuntimeException('Unable to create image using GD library.');
            }

            $red = $this->getBackgroundColor()->getRed();
            $green = $this->getBackgroundColor()->getGreen();
            $blue = $this->getBackgroundColor()->getBlue();
            $alpha = (int) min([127, round(127 * $this->getBackgroundColor()->getAlpha(), 0)]);

            if (false === imagecolorallocatealpha($this->resource, $red, $green, $blue, $alpha)) {
                throw new RuntimeException('Unable to allocate background color using GD library.');
            }
        }

        return $this->resource;
    }

    /**
     * Get raw contents of the image.
     *
     * @return string
     * @throws RuntimeException
     */
    protected function raw()
    {
        ob_start();

        switch ($this->type) {
            case AdapterInterface::TYPE_JPG :
                $result = imagejpeg($this->getResource());
                break;

            case AdapterInterface::TYPE_PNG :
                $result = imagepng($this->getResource());
                break;

            case AdapterInterface::TYPE_GIF :
                $result = imagegif($this->getResource());
                break;
        }

        $raw = ob_get_contents();
        ob_end_clean();

        if (false === $result) {
            throw new RuntimeException('Unable to get image contents.');
        }

        return $raw;
    }

    /**
     * Save the image to a file.
     *
     * @param string $file
     * @return void
     * @throws \RuntimeException
     */
    public function save($file)
    {
        if (false === file_put_contents($file, $this->raw())) {
            throw new RuntimeException(sprintf('Unable to save image to file "%s".', $file));
        }
    }

    /**
     * Output image contents as a Base64 encoded string.
     *
     * @return string
     */
    public function output()
    {
        return base64_encode($this->raw());
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
        $allowed = [
            AdapterInterface::TYPE_JPG,
            AdapterInterface::TYPE_PNG,
            AdapterInterface::TYPE_GIF,
        ];

        if (false === in_array((int) $type, $allowed)) {
            throw new InvalidArgumentException('Invalid type provided.');
        }

        $this->type = (int) $type;

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
