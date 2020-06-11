<?php


namespace PHPML\Graphics\Shape;

use FFI\CData;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CSFMLType;
use PHPML\Library\GraphicsLibLoader as Lib;

class Position
{
    use MyCData;

    private float $xPos;
    private float $yPos;

    /**
     * Position constructor.
     *
     * @param float $xPos position x
     * @param float $yPos position y
     */
    public function __construct(float $xPos, float $yPos)
    {
        $this->xPos = $xPos;
        $this->yPos = $yPos;
    }


    /**
     * Accesseur à la position X
     *
     * @return float
     */
    public function getXPos(): float
    {
        if ($this->isCDataLoad()) {
            $this->xPos = $this->cdata->x;
        }
        return $this->xPos;
    }

    /**
     * Modificateur de la valeur x de la position.
     *
     * @param float $xPos nouvelle valeur
     */
    public function setXPos(float $xPos): void
    {
        if ($this->isCDataLoad()) {
            $this->cdata->x = $xPos;
        }
        $this->xPos = $xPos;
    }

    /**
     * Accesseur à la position Y
     *
     * @return float
     */
    public function getYPos(): float
    {
        if ($this->isCDataLoad()) {
            $this->yPos = $this->cdata->y;
        }
        return $this->yPos;
    }

    /**
     * Modificateur de la valeur x de la position.
     *
     * @param float $yPos nouvelle valeur
     */
    public function setYPos(float $yPos): void
    {
        if ($this->isCDataLoad()) {
            $this->cdata->y = $yPos;
        }
        $this->yPos = $yPos;
    }

    /**
     * @inheritDoc
     */
    public function toCData(): CData
    {
        $this->cdata ??= Lib::getGraphicsLib()->new(
            Lib::getGraphicsLib()->type(CSFMLType::VECTOR_2F)
        );

        $this->cdata->x = $this->xPos;
        $this->cdata->y = $this->yPos;

        return $this->cdata;
    }
}
