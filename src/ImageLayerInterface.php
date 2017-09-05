<?php

namespace ImgDyn;

interface ImageLayerInterface
{

    /**
     * Get image width.
     *
     * @return int
     */
    public function getWidth();

    /**
     * Get image height.
     *
     * @return int
     */
    public function getHeight();

    /**
     * set image type.
     *
     * @param int $type
     * @return \ImageLayerInterface
     */
    public function setType($type);

    /**
     * Get image type.
     *
     * @return int
     */
    public function getType();

    /**
     * Set layer position.
     *
     * @param \ImgDyn\PointInterface $position
     * @return \ImgDyn\ImageLayerInterface
     */
    public function setPosition(PointInterface $position);

    /**
     * Get layer position.
     *
     * @return \ImgDyn\PointInterface
     */
    public function getPosition();

    /**
     * Helper method to easily set x-position.
     *
     * @param int $x
     * @return \ImageLayerInterface
     */
    public function setX($x);

    /**
     * Helper method to easily get x-position.
     *
     * @return int
     */
    public function getX();

    /**
     * Helper method to easily set y-position.
     *
     * @param int $y
     * @return \ImageLayerInterface
     */
    public function setY($y);

    /**
     * Helper method to easily get y-position.
     *
     * @return int
     */
    public function getY();

    /**
     * Get the image contents as a binary string.
     *
     * @return string
     * @throws RuntimeException
     */
    public function getContents();

    /**
     * Get size of the image in bytes.
     *
     * @return int
     */
    public function getSize();

    /**
     * Load the content of a file into the image.
     *
     * @param string $file
     * @return \ImgDyn\GdImageLayer
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function load($file);

    /**
     * Duplicate the current instance into a new object.
     *
     * @return \ImgDyn\ImageLayerInterface
     */
    public function copy();

    /**
     * Export the merged image to a file.
     *
     * @param string $file
     * @return \ImgDyn\ImageLayerInterface
     * @throws \RuntimeException
     */
    public function export($file);

    /**
     * Merge all layers into a single image.
     *
     * @return \ImgDyn\ImageLayerInterface
     */
    public function merge();

    /**
     * Add new layer to the top of the image.
     *
     * @param \ImgDyn\ImageLayerInterface $layer
     * @param string|null $name
     * @return \ImgDyn\ImageInterface
     */
    public function addLayer(ImageLayerInterface $layer, $name = null);

    /**
     * Check either a layer exists by name.
     *
     * @param string $name
     * @return bool
     */
    public function hasLayer($name);

    /**
     * Get layer by name.
     *
     * @param string $name
     * @return \ImgDyn\ImageLayerInterface|null
     */
    public function getLayer($name);

    /**
     * Remove given layer from the image.
     *
     * @param string $name
     * @return \ImgDyn\ImageLayerInterface
     */
    public function removeLayer($name);

    /**
     * Get an array with all layer of the image.
     *
     * @return array
     */
    public function getLayers();
}
