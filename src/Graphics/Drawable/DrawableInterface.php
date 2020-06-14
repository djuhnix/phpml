<?php


namespace PHPML\Graphics\Drawable;


use PHPML\Graphics\Window;

interface DrawableInterface
{
    /**
     * Retourne le nom du type C équivalent de l'objet
     *
     * @return string le nom du type CSFML
     */
    function getTypeName(): string;

    /**
     * Dessine cette forme sur la fenêtre.
     *
     * @param Window $target
     */
    function draw(Window $target) : void;

}