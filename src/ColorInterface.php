<?php

namespace ImgDyn;

interface ColorInterface
{

    /**
     * Get Red value (0-255)
     *
     * @return int
     */
    public function getRed();

    /**
     * Get Green value (0-255)
     *
     * @return int
     */
    public function getGreen();

    /**
     * Get Blue value (0-255)
     *
     * @return int
     */
    public function getBlue();

    /**
     * Get Alpha value (0%-100%)
     *
     * @return float
     */
    public function getAlpha();
}
