<?php

namespace ImgDyn;

interface LayerInterface
{

    /**
     * Set layer name.
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Get layer name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get layer position.
     *
     * @return \ImgDyn\PointInterface
     */
    public function getPosition();

    /**
     * Set layer position.
     *
     * @param \ImgDyn\PointInterface $position
     */
    public function setPosition(PointInterface $position);

    /**
     * Get layer contents.
     *
     * @return \Img\Dyn\ImageInterface
     */
    public function getImage();

    /**
     * Set layer contents.
     *
     * @param \Img\Dyn\ImageInterface $image
     */
    public function setImage(ImageInterface $image);
}
