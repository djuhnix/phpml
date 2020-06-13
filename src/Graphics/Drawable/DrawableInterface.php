<?php


namespace PHPML\Graphics\Drawable;

use PHPML\Enum\Color;
use PHPML\Graphics\Texture;
use PHPML\Graphics\DrawingWindow;

interface DrawableInterface
{
    /**
     * Dessine cette forme sur la fenêtre.
     *
     * @param DrawingWindow $target
     */
    public function draw(DrawingWindow $target): void;

    /**
     * Accesseur à la couleur de remplissage
     *
     * @return Color|null
     */
    public function getFillColor(): ?Color;

    /**
     * Modificateur de la couleur de remplissage.
     *
     * @param Color $fillColor nouvelle couleur
     */
    public function setFillColor(Color $fillColor): void;

    /**
     * Accesseur à la couleur des bords
     *
     * @return Color
     */
    public function getOutlineColor(): ?Color;

    /**
     * Modificateur de la couleur des bords
     *
     * @param Color $outlineColor la nouvelle couleur
     */
    public function setOutlineColor(Color $outlineColor): void;

    /**
     * Accesseur à l'épaisseur
     *
     * @return float
     */
    public function getOutlineThickness(): float;

    /**
     * Modificateur de l'épaisseur
     *
     * @param float $outlineThickness
     */
    public function setOutlineThickness(float $outlineThickness): void;

    /**
     * Accesseur à la position.
     *
     * @return array le couple de coordonnées de la position
     */
    public function getPosition(): array;

    /**
     * Modificateur de la position.
     *
     * @param array $position la nouvelle position
     */
    public function setPosition(array $position): void;

    /**
     * Accesseur à la texture
     *
     * @return Texture|null
     */
    public function getTexture(): ?Texture;

    /**
     * Change la texture de l'élément à dessiner.
     * La texture doit exister aussi longtemps que cet éléments continue à l'utiliser au risque d'avoir un comportement non voulu.
     *
     * @param Texture $texture la texture à utiliser
     * @param bool $resetRect défini s'il faut redimensionner la zone de sélection de la texture à la nouvelle texture ?
     */
    public function setTexture(Texture $texture, bool $resetRect): void;
}
