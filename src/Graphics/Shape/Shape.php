<?php


namespace PHPML\Graphics\Shape;

use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\Color;
use PHPML\Graphics\Window;

abstract class Shape
{
    use MyCData;

    protected Position $position;
    protected Color $fillColor;
    protected Color $outlineColor;
    protected float $outlineThickness;

    /**
     * Accesseur à la couleur de remplissage
     *
     * @return Color
     */
    public function getFillColor(): Color
    {
        if ($this->isCDataLoad()) {

        }
        return $this->fillColor;
    }

    /**
     * Modificateur de la couleur de remplissage.
     *
     * @param Color $fillColor nouvelle couleur
     */
    public function setFillColor(Color $fillColor): void
    {
        $this->fillColor = $fillColor;
    }

    /**
     * Accesseur à la couleur des bords
     *
     * @return Color
     */
    public function getOutlineColor(): Color
    {
        return $this->outlineColor;
    }

    /**
     * Modificateur de la couleur des bords
     *
     * @param Color $outlineColor la nouvelle couleur
     */
    public function setOutlineColor(Color $outlineColor): void
    {
        $this->outlineColor = $outlineColor;
    }

    /**
     * Accesseur à l'épaisseur
     *
     * @return float
     */
    public function getOutlineThickness(): float
    {
        return $this->outlineThickness;
    }

    /**
     * Modificateur de l'épaisseur
     *
     * @param float $outlineThickness
     */
    public function setOutlineThickness(float $outlineThickness): void
    {
        $this->outlineThickness = $outlineThickness;
    }

    /**
     * Accesseur à la position.
     *
     * @return Position
     */
    abstract public function getPosition(): Position;

    /**
     * Modificateur de la position.
     *
     * @param Position $position la nouvelle position
     */
    abstract public function setPosition(Position $position): void;

    /**
     * Dessine cette forme sur la fenêtre.
     *
     * @param Window $target
     */
    abstract public function draw(Window $target) : void;
}
