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
     * Use first argument to load an image from a file which fills dimensions
     * and type from the loaded image. Alternatively set first argument to null
     * provide width and height to create a new empty image.
     *
     * @param string $file
     * @param int|null $width
     * @param int|null $height
     * @param int|null $type
     * @param ColorInterface|null $backgroundColor
     * @throws InvalidArgumentException
     */
    public function __construct($file, $width = null, $height = null, $type = null, ColorInterface $backgroundColor = null)
    {
        if (null !== $file) {
            $this->load($file);
            return;
        }

        if ($width <= 0) {
            throw new InvalidArgumentException('Width of image must be greater than 0.');
        }

        if ($height <= 0) {
            throw new InvalidArgumentException('Height of image must be greater than 0.');
        }

        if (null === $type) {
            $type = AdapterInterface::TYPE_PNG;
        }

        if (false === $this->isValidType($type)) {
            throw new InvalidArgumentException('Unsupported image type provided.');
        }

        if (null === $backgroundColor) {
            $backgroundColor = new Color();
        }

        $this->width = (int) $width;
        $this->height = (int) $height;
        $this->type = (int) $type;
        $this->backgroundColor = $backgroundColor;
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
     * @return \ImgDyn\AdapterInterface
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function load($file)
    {
        if (false === file_exists($file) || false === is_readable($file)) {
            throw new InvalidArgumentException(sprintf('File "%s" does not exist or is not readable.', $file));
        }

        if (false === $info = getimagesize($file)) {
            throw new InvalidArgumentException(sprintf('File "%s" is not an image.', $file));
        }

        if (false === $this->isValidType($info[2])) {
            throw new InvalidArgumentException(sprintf('File "%s" iamge type is not supported.', $file));
        }

        switch ($info[2]) {
            case AdapterInterface::TYPE_GIF:
                $this->resource = imagecreatefromgif($file);
                break;
            case AdapterInterface::TYPE_JPG:
                $this->resource = imagecreatefromjpeg($file);
                break;
            case AdapterInterface::TYPE_PNG:
                $this->resource = imagecreatefrompng($file);
                break;
        }

        if (false === $this->resource) {
            throw new RuntimeException('Unable to create image resource using GD library.');
        }

        $this->width = (int) $info[0];
        $this->height = (int) $info[1];
        $this->type = (int) $info[2];

        return $this;
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
            case AdapterInterface::TYPE_JPG:
                $result = imagejpeg($this->getResource());
                break;

            case AdapterInterface::TYPE_PNG:
                $result = imagepng($this->getResource());
                break;

            case AdapterInterface::TYPE_GIF:
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
     * @return \ImgDyn\AdapterInterface
     * @throws \RuntimeException
     */
    public function save($file)
    {
        if (false === file_put_contents($file, $this->raw())) {
            throw new RuntimeException(sprintf('Unable to save image to file "%s".', $file));
        }

        return $this;
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
     * Checks either type is valid or not.
     *
     * @param int $type
     * @return bool
     */
    protected function isValidType($type)
    {
        $allowedTypes = [
            AdapterInterface::TYPE_JPG,
            AdapterInterface::TYPE_PNG,
            AdapterInterface::TYPE_GIF,
        ];

        return in_array((int) $type, $allowedTypes);
    }

    /**
     * Get size of the image in bytes.
     *
     * @return int
     */
    public function getSize()
    {
        return strlen($this->raw());
    }

    /**
     * Export current image to a different type.
     *
     * @param int $type
     * @return \ImgDyn\AdapterInterface
     * @throws InvalidArgumentException
     */
    public function export($type)
    {
        if (false === $this->isValidType($type)) {
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
     * @return \ImgDyn\AdapterInterface
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function resize($width, $height)
    {
        if ($width < 1) {
            throw new InvalidArgumentException('Image width must be greater than 0.');
        }

        if ($height < 1) {
            throw new InvalidArgumentException('Image height must be greater than 0.');
        }

        if (false === $resource = imagecreatetruecolor($width, $height)) {
            throw new RuntimeException('Unable to create new image resource using GD library.');
        }

        if (false === imagecopyresampled($resource, $this->getResource(), 0, 0, 0, 0, $width, $height, $this->width, $this->height)) {
            throw new RuntimeException('Unable to resample image using GD library.');
        }

        if (false === imagedestroy($this->resource)) {
            throw new RuntimeException('Unable to destroy image resource using GD library.');
        }

        $this->resource = $resource;
        $this->width = $width;
        $this->height = $height;

        return $this;
    }

    /**
     * Crop image from one position to another one.
     *
     * @param PointInterface $from
     * @param PointInterface $to
     * @return \ImgDyn\AdapterInterface
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function crop(PointInterface $from, PointInterface $to)
    {
        if (1 > $width = $to->getX() - $from->getX()) {
            throw new InvalidArgumentException('Cropping an image requires a positive width.');
        }

        if (1 > $height = $to->getY() - $from->getY()) {
            throw new InvalidArgumentException('Cropping an image requires a positive height.');
        }

        if (false === $resource = imagecreatetruecolor($width, $height)) {
            throw new RuntimeException('Unable to create new image resource using GD library.');
        }

        if (false === imagecopy($resource, $this->getResource(), 0, 0, $from->getX(), $from->getY(), $width, $height)) {
            throw new RuntimeException('Unable to copy image using GD library.');
        }

        if (false === imagedestroy($this->resource)) {
            throw new RuntimeException('Unable to destroy image resource using GD library.');
        }

        $this->resource = $resource;
        $this->width = $width;
        $this->height = $height;

        return $this;
    }
}
