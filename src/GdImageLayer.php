<?php

namespace ImgDyn;

use InvalidArgumentException;
use RuntimeException;

class GdImageLayer extends AbstractImageLayer implements ImageLayerInterface
{

    /**
     * @var resource
     */
    protected $resource;

    /**
     * Create new instance of ImageLayerInterface.
     *
     * Use first argument to load an image from a file which fills dimensions
     * and type from the loaded image. Alternatively set first argument to null
     * provide width and height to create a new empty image.
     *
     * @param string $file
     * @param int|null $width
     * @param int|null $height
     * @param int|null $type
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function __construct($file, $width = null, $height = null, $type = IMAGETYPE_PNG)
    {
        if (false === extension_loaded('gd')) {
            throw new RuntimeException('This class requires GD extension which is not loaded.');
        }

        parent::__construct($file, $width, $height, $type);
    }

    /**
     * Make a copy of the current object using the clone command.
     *
     * @return \ImgDyn\ImageLayerInterface
     */
    public function __clone()
    {
        $copy = imagecreatetruecolor($this->getWidth(), $this->getHeight());
        imagecopy($copy, $this->getResource(), 0, 0, 0, 0, $this->getWidth(), $this->getHeight());

        $this->resource = $copy;

        $layers = [];

        foreach ($this->layers as $name => $layer) {
            $layers[$name] = clone $layer;
        }

        $this->layers = $layers;
    }

    /**
     * Destroy image resource on shutdown process.
     *
     * @return void
     */
    public function __destruct()
    {
        if (null !== $this->resource) {
            imagedestroy($this->resource);
        }
    }

    /**
     * Load the content of a file into the image.
     *
     * @param string $file
     * @return \ImgDyn\GdImageLayer
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

        switch ($info[2]) {
            case IMAGETYPE_GIF:
                $this->resource = imagecreatefromgif($file);
                break;
            case IMAGETYPE_JPEG:
                $this->resource = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG:
                $this->resource = imagecreatefrompng($file);
                break;
        }

        if (false === $this->resource) {
            throw new RuntimeException('Unable to create image resource using GD library.');
        }

        $this->width = (int) $info[0];
        $this->height = (int) $info[1];

        $this->setType($info[2]);

        return $this;
    }

    /**
     * Get the image contents as a binary string.
     *
     * @return string
     * @throws RuntimeException
     */
    public function getContents()
    {
        ob_start();

        switch ($this->type) {
            case IMAGETYPE_GIF:
                $result = imagegif($this->getResource());
                break;

            case IMAGETYPE_PNG:
                $result = imagepng($this->getResource());
                break;

            case IMAGETYPE_JPEG:
                $result = imagejpeg($this->getResource());
                break;
        }

        $contents = ob_get_contents();
        ob_end_clean();

        if (false === $result) {
            throw new RuntimeException('Unable to get image contents.');
        }

        return $contents;
    }

    /**
     * Merge all layers into a single image.
     *
     * @return \ImgDyn\ImageLayerInterface
     */
    public function merge()
    {
        $this->getResource();

        foreach ($this->layers as $layer) {
            $contents = $layer->merge()->getContents();
            $image = imagecreatefromstring($contents);
            imagecopy($this->resource, $image, $layer->getPosition()->getX(), $layer->getPosition()->getY(), 0, 0, $layer->getWidth(), $layer->getHeight());
            imagedestroy($image);
        }

        $this->layers = [];

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
        }

        return $this->resource;
    }

    /**
     * Scale the image dimensions.
     *
     * @param int $width
     * @param int $height
     * @return \ImgDyn\ImageLayerInterface
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function scale($width, $height)
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

        $widthRatio = $width / $this->width;
        $heightRatio = $height / $this->height;

        $this->resource = $resource;
        $this->width = $width;
        $this->height = $height;

        foreach ($this->layers as $layer) {
            $width = ceil($layer->getWidth() * $widthRatio);
            $height = ceil($layer->getHeight() * $heightRatio);

            $layer->resize($width, $height);
        }

        return $this;
    }

    /**
     * Crop image from one position to another.
     *
     * @param PointInterface $from
     * @param PointInterface $to
     * @return \ImgDyn\ImageLayerInterface
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

        imagedestroy($this->resource);

        $this->resource = $resource;
        $this->width = $width;
        $this->height = $height;

        foreach ($this->layers as $layer) {
            $x = $layer->getX() - $from->getX();
            $y = $layer->getY() - $from->getY();

            $layer->setX($x)->setY($y);
        }

        return $this;
    }
}
