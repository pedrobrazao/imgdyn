<?php

namespace ImgDyn;

interface ImageInterface extends AdapterInterface
{

    const TYPE_JPG = 1;
    const TYPE_PNG = 2;
    const TYPE_GIF = 3;

    /**
     * Resize the image width and adjust height proportionally.
     *
     * @param int $width
     */
    public function resizeWidth($width);

    /**
     * Resize the image height and adjust width proportionally.
     *
     * @param int $height
     */
    public function resizeHeight($height);

    /**
     * Add new layer to the top of the image.
     *
     * @param \ImgDyn\LayerInterface $layer
     */
    public function addLayer(LayerInterface $layer);

    /**
     * Remove given layer from the image.
     *
     * @param \ImgDyn\LayerInterface $layer
     */
    public function removeLayer(LayerInterface $layer);

    /**
     * Get an array with all layer of the image.
     *
     * @return array
     */
    public function getLayers();

    /**
     * Get layer by name.
     *
     * @param string $name
     * @return \ImgDyn\LayerInterface|null
     */
    public function getLayerByName($name);
}
