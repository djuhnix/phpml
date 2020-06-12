<?php


namespace PHPML\Graphics\Drawable;

use PHPML\Graphics\Window;

interface DrawableInterface
{
    /**
     * Dessine cette forme sur la fenêtre.
     *
     * @param Window $target
     */
    public function draw(Window $target) : void;
}
