<?php

namespace ImgDyn;

interface AdapterInterface
{

    /**
     * Image types supported.
     */
    const TYPE_GIF = 1;
    const TYPE_JPG = 2;
    const TYPE_PNG = 4;

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
     * @return \ImgDyn\AdapterInterface
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function load($file);

    /**
     * Save the image to a file.
     *
     * @param string $file
     * @return \ImgDyn\AdapterInterface
     * @throws \RuntimeException
     */
    public function save($file);

    /**
     * Output image contents as a Base64 encoded string.
     *
     * @return string
     */
    public function output();

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
     * @return \ImgDyn\AdapterInterface
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function resize($width, $height);

    /**
     * Crop image from one position to another one.
     *
     * @param PointInterface $from
     * @param PointInterface $to
     * @return \ImgDyn\AdapterInterface
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function crop(PointInterface $from, PointInterface $to);
}
