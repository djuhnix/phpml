<?php


namespace PHPML\Graphics;

use FFI\CData;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CSFMLType;
use PHPML\Exception\CDataException;
use PHPML\Library\GraphicsLibLoader as Lib;

abstract class Position
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
    public function __construct(float $xPos = 0, float $yPos = 0)
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
        $this->updateFromCData();
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
        $this->updateFromCData();
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
            Lib::getGraphicsLib()->type($this->getPositionType())
        );

        $this->cdata->x = $this->xPos;
        $this->cdata->y = $this->yPos;

        return $this->cdata;
    }

    /**
     * @inheritDoc
     */
    protected function updateFromCData(): void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("Les données C de Position doivent être chargées pour mettre à jour les donnée de la classe.");
        }
        $this->xPos = $this->cdata->x;
        $this->yPos = $this->cdata->y;
    }

    /**
     * Accesseur au type C de la position.
     *
     * @return string le type C de la position
     */
    abstract protected function getPositionType(): string ;
}
