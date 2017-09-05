<?php

namespace ImgDyn;

use InvalidArgumentException;

abstract class AbstractImageLayer
{

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var int
     */
    protected $type;

    /**
     * @var \ImgDyn\PointInterface
     */
    protected $position;

    /**
     * @var \Phower\Arrays\Stack
     */
    protected $layers = [];

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
     */
    public function __construct($file, $width = null, $height = null, $type = IMAGETYPE_PNG)
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

        $this->width = (int) $width;
        $this->height = (int) $height;

        $this->setType($type);
    }

    /**
     * Output any instance of this class as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getContents();
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
     * set image type.
     *
     * @param int $type
     * @return \ImageLayerInterface
     */
    public function setType($type)
    {
        $allowedTypes = [
            IMAGETYPE_GIF,
            IMAGETYPE_JPEG,
            IMAGETYPE_PNG,
        ];

        if (false === in_array((int) $type, $allowedTypes)) {
            throw new InvalidArgumentException('Unsupported type provided.');
        }

        foreach ($this->layers as $layer) {
            $layer->setType($type);
        }

        $this->type = (int) $type;

        return $this;
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
     * Set layer position.
     *
     * @param \ImgDyn\PointInterface $position
     * @return \ImgDyn\ImageLayerInterface
     */
    public function setPosition(PointInterface $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get layer position.
     *
     * @return \ImgDyn\PointInterface
     */
    public function getPosition()
    {
        if (null === $this->position) {
            $this->position = new Point(0, 0);
        }

        return $this->position;
    }

    /**
     * Helper method to easily set x-position.
     *
     * @param int $x
     * @return \ImageLayerInterface
     */
    public function setX($x)
    {
        $position = new Point($x, $this->getPosition()->getY());
        $this->position = $position;

        return $this;
    }

    /**
     * Helper method to easily get x-position.
     *
     * @return int
     */
    public function getX()
    {
        return $this->position->getX();
    }

    /**
     * Helper method to easily set y-position.
     *
     * @param int $y
     * @return \ImageLayerInterface
     */
    public function setY($y)
    {
        $position = new Point($y, $this->getPosition()->getY());
        $this->position = $position;

        return $this;
    }

    /**
     * Helper method to easily get y-position.
     *
     * @return int
     */
    public function getY()
    {
        return $this->position->getY();
    }

    /**
     * Duplicate the current instance into a new object.
     *
     * @return \ImgDyn\ImageLayerInterface
     */
    public function copy()
    {
        return clone $this;
    }

    /**
     * Export the merged image to a file.
     *
     * @param string $file
     * @return \ImgDyn\ImageLayerInterface
     * @throws \RuntimeException
     */
    public function export($file)
    {
        $image = $this->copy()->merge();

        if (false === file_put_contents($file, $image->getContents())) {
            throw new RuntimeException(sprintf('Unable to save image to file "%s".', $file));
        }

        return $this;
    }

    /**
     * Get size of the image in bytes.
     *
     * @return int
     */
    public function getSize()
    {
        return strlen($this->getContents());
    }

    /**
     * Add new layer to the top of the image.
     *
     * @param \ImgDyn\ImageLayerInterface $layer
     * @param string $name
     * @return \ImgDyn\ImageInterface
     */
    public function addLayer(ImageLayerInterface $layer, $name)
    {
        $this->layers[$name] = $layer;

        return $this;
    }

    /**
     * Check either a layer exists by name.
     *
     * @param string $name
     * @return bool
     */
    public function hasLayer($name)
    {
        return isset($this->layers[$name]);
    }

    /**
     * Get layer by name.
     *
     * @param string $name
     * @return \ImgDyn\ImageLayerInterface|null
     */
    public function getLayer($name)
    {
        if (false === isset($this->layers[$name])) {
            return null;
        }

        return $this->layers[$name];
    }

    /**
     * Remove given layer from the image.
     *
     * @param string $name
     * @return \ImgDyn\ImageLayerInterface
     */
    public function removeLayer($name)
    {
        unset($this->layers[$name]);

        return $this;
    }

    /**
     * Get an array with all layer of the image.
     *
     * @return array
     */
    public function getLayers()
    {
        return $this->layers;
    }
}
