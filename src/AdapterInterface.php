<?php

namespace ImgDyn;

interface AdapterInterface
{
    const TYPE_JPG = 1;
    const TYPE_PNG = 2;
    const TYPE_GIF = 3;

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
     * Set image background color.
     *
     * @param \ImgDyn\ColorInterface $color
     */
    public function setBackgroundColor(ColorInterface $color);

    /**
     * Get image background color.
     *
     * @return \ImgDyn\ColorInterface
     */
    public function getBackgroundColor();

    /**
     * Load the content of a file into the image.
     *
     * @param string $file
     */
    public function load($file);

    /**
     * Optionally save the image to a file and returns its contents encoded as Base64 string.
     *
     * @param string|null $file
     * @return string
     */
    public function save($file = null);

    /**
     * Get image type.
     *
     * @return int
     */
    public function getType();

    /**
     * Set image type.
     *
     * @param int $type
     */
    public function setType($type);

    /**
     * Resize the image dimensions.
     *
     * @param int $width
     * @param int $height
     */
    public function resize($width, $height);

    /**
     * Crop image from one position to another one.
     *
     * @param PointInterface $from
     * @param PointInterface $to
     */
    public function crop(PointInterface $from, PointInterface $to);
}
