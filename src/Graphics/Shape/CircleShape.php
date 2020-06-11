<?php

namespace PHPML\Graphics\Shape;

use FFI\CData;
use PHPML\Enum\Color;
use PHPML\Exception\CDataException;
use PHPML\Graphics\Window;
use PHPML\Library\GraphicsLibLoader as Lib;

class CircleShape extends Shape
{
    /**
     * @var float Rayon du cercle
     */
    private float $radius;

    /**
     * CircleShape constructor.
     * @param float $radius
     * @param Color|null $fillColor
     */
    public function __construct(float $radius, Color $fillColor = null)
    {
        $this->radius = $radius;
        $this->fillColor = $fillColor ?? new Color(Color::RED);
        $this->outlineThickness = 0;
        $this->outlineColor = $this->fillColor;
    }

    public function __destruct()
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfCircleShape_destroy($this->cdata);
            unset($this->cdata);
        }
    }

    /**
     * @param Color $fillColor
     */
    public function setFillColor(Color $fillColor): void
    {
        $this->fillColor = $fillColor;
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfCircleShape_setFillColor(
                $this->cdata,
                $fillColor->getCDataColor()
            );
        }
    }

    /**
     * @param Color $outlineColor
     */
    public function setOutlineColor(Color $outlineColor): void
    {
        $this->outlineColor = $outlineColor;
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfCircleShape_setOutlineColor(
                $this->cdata,
                $outlineColor->getCDataColor()
            );
        }
    }

    /**
     * @param float $outlineThickness
     */
    public function setOutlineThickness(float $outlineThickness): void
    {
        $this->outlineThickness = $outlineThickness;
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfCircleShape_setOutlineThickness($this->cdata, $this->outlineThickness);
        }
    }

    /**
     * @return float
     */
    public function getRadius(): float
    {
        if ($this->isCDataLoad()) {
            $this->radius = Lib::getGraphicsLib()->sfCircleShape_getRadius($this->cdata);
        }
        return $this->radius;
    }

    /**
     * @param float $radius
     */
    public function setRadius(float $radius): void
    {
        $this->radius = $radius;
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfCircleShape_setRadius($this->cdata, $this->radius);
        }
    }

    /**
     * @inheritDoc
     */
    public function getPosition(): Position
    {
        if ($this->isCDataLoad()) {
            $positionCData = Lib::getGraphicsLib()->sfCircleShape_getPosition($this->cdata);
            $this->position->setXPos($positionCData->x);
            $this->position->setYPos($positionCData->y);
        }
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    public function setPosition(Position $position): void
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfCircleShape_setPosition(
                $this->cdata,
                $position->toCData()
            );
        }
        $this->position = $position;
    }

    /**
     * @inheritDoc
     */
    public function toCData(): CData
    {
        // TODO: Implement toCData() method.
        $this->cdata ??= Lib::getGraphicsLib()->sfCircleShape_create();
        if (\FFI::isNull($this->cdata)) {
            throw new CDataException("Erreur de chargement lors de la création du cercle.");
        }
        $this->setRadius($this->radius);
        $this->setFillColor($this->fillColor);
        $this->setOutlineColor($this->outlineColor);
        $this->setOutlineThickness($this->outlineThickness);
        $this->setPosition($this->position);

        return $this->cdata;
    }

    public function draw(Window $target): void
    {
        if (!$target->isCDataLoad()) {
            throw new CDataException("Les données C de la fenêtre n'ont pas été chargé pour pouvoir y dessiner un cercle.");
        }
        Lib::getGraphicsLib()->sfRenderWindow_drawCircleShape($target->getCData(), $this->toCData(), null);
    }
}
