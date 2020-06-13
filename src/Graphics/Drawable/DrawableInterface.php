<?php


namespace PHPML\Graphics\Drawable;

use PHPML\Graphics\Texture;
use PHPML\Graphics\Window;

interface DrawableInterface
{
    /**
     * Dessine cette forme sur la fenêtre.
     *
     * @param Window $target
     */
    public function draw(Window $target): void;

    /**
     * Change la texture de l'élément à dessiner.
     * La texture doit exister aussi longtemps que cet éléments continue à l'utiliser au risque d'avoir un comportement non voulu.
     *
     * @param Texture $texture la texture à utiliser
     * @param bool $resetRect défini s'il faut redimensionner la zone de sélection de la texture à la nouvelle texture ?
     */
    public function setTexture(Texture $texture, bool $resetRect): void;
}
