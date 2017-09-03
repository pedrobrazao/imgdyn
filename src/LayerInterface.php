<?php

namespace ImgDyn;

interface LayerInterface
{
    /**
     * Set layer name.
     *
     * @param string $name
     * @return \ImgDyn\LayerInterface
     */
    public function setName($name);

    /**
     * Get layer name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set layer position.
     *
     * @param \ImgDyn\PointInterface $position
     * @return \ImgDyn\LayerInterface
     */
    public function setPosition(PointInterface $position);

    /**
     * Get layer position.
     *
     * @return \ImgDyn\PointInterface
     */
    public function getPosition();

    /**
     * Set layer contents.
     *
     * @param \Img\Dyn\ImageInterface $image
     * @return \ImgDyn\LayerInterface
     */
    public function setImage(ImageInterface $image = null);

    /**
     * Get layer contents.
     *
     * @return \Img\Dyn\ImageInterface|null
     */
    public function getImage();
}
