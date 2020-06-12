<?php


namespace PHPML\Graphics\Shape;

use PHPML\Enum\Color;
use PHPML\AbstractFFI\MyCData;
use PHPML\Graphics\FloatPosition as Position;
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
        $this->updateFromCData();
        return $this->fillColor;
    }

    /**
     * Accesseur à la couleur des bords
     *
     * @return Color
     */
    public function getOutlineColor(): Color
    {
        $this->updateFromCData();
        return $this->outlineColor;
    }

    /**
     * Accesseur à l'épaisseur
     *
     * @return float
     */
    public function getOutlineThickness(): float
    {
        $this->updateFromCData();
        return $this->outlineThickness;
    }

    /**
     * Accesseur à la position.
     *
     * @return Position
     */
    public function getPosition(): Position
    {
        $this->updateFromCData();
        return $this->position;
    }

    /**
     * Modificateur de la couleur de remplissage.
     *
     * @param Color $fillColor nouvelle couleur
     */
    abstract public function setFillColor(Color $fillColor): void;

    /**
     * Modificateur de la couleur des bords
     *
     * @param Color $outlineColor la nouvelle couleur
     */
    abstract public function setOutlineColor(Color $outlineColor): void;

    /**
     * Modificateur de l'épaisseur
     *
     * @param float $outlineThickness
     */
    abstract public function setOutlineThickness(float $outlineThickness): void;

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
