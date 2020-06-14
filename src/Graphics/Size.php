<?php


namespace PHPML\Graphics;

use FFI\CData;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CSFMLType;
use PHPML\Exception\CDataException;
use PHPML\Library\GraphicsLibLoader as Lib;

class Size
{
    use MyCData;

    private float $width;
    private float $height;

    /**
     * Position constructor.
     *
     * @param float $width position x
     * @param float $height position y
     */
    public function __construct(float $width, float $height)
    {
        $this->width = $width;
        $this->height = $height;
    }


    /**
     * Accesseur à la largeur
     *
     * @return float
     */
    public function getWidth(): float
    {
        $this->updateFromCData();
        return $this->width;
    }

    /**
     * Modificateur de la largeur de la position.
     *
     * @param float $width nouvelle valeur
     */
    public function setWidth(float $width): void
    {
        if ($this->isCDataLoad()) {
            $this->cdata->x = $width;
        }
        $this->width = $width;
    }

    /**
     * Accesseur à la hauteur
     *
     * @return float
     */
    public function getHeight(): float
    {
        $this->updateFromCData();
        return $this->height;
    }

    /**
     * Modificateur de la hauteur.
     *
     * @param float $height nouvelle valeur
     */
    public function setHeight(float $height): void
    {
        if ($this->isCDataLoad()) {
            $this->cdata->y = $height;
        }
        $this->height = $height;
    }

    /**
     * @inheritDoc
     */
    public function toCData(): CData
    {
        $this->cdata ??= Lib::getGraphicsLib()->new(
            Lib::getGraphicsLib()->type(CSFMLType::VECTOR_2U)
        );

        $this->cdata->x = $this->width;
        $this->cdata->y = $this->height;

        return $this->cdata;
    }

    protected function updateFromCData(): void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("Les données C de Size doivent être chargées pour mettre à jour les données de la classe.");
        }
        $this->width = $this->cdata->x;
        $this->height = $this->cdata->y;
    }
}
