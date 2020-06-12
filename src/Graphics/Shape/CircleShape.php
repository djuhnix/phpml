<?php

namespace PHPML\Graphics\Shape;

use FFI\CData;
use PHPML\Enum\Color;
use PHPML\Exception\CDataException;
use PHPML\Graphics\FloatPosition as Position;
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
     * @param Position $position
     * @param Color|null $fillColor
     */
    public function __construct(float $radius, Position $position = null, Color $fillColor = null)
    {
        $this->radius = $radius;
        $this->position = $position ?? new Position();
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
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfCircleShape_setFillColor(
                $this->cdata,
                $fillColor->getCDataColor()
            );
        }
        $this->fillColor = $fillColor;
    }

    /**
     * @param Color $outlineColor
     */
    public function setOutlineColor(Color $outlineColor): void
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfCircleShape_setOutlineColor(
                $this->cdata,
                $outlineColor->getCDataColor()
            );
        }
        $this->outlineColor = $outlineColor;
    }

    /**
     * @param float $outlineThickness
     */
    public function setOutlineThickness(float $outlineThickness): void
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfCircleShape_setOutlineThickness($this->cdata, $this->outlineThickness);
        }
        $this->outlineThickness = $outlineThickness;
    }

    /**
     * Accesseur au rayon du cercle.
     *
     * @return float le rayon
     */
    public function getRadius(): float
    {
        $this->updateFromCData();
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

    protected function updateFromCData(): void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de CircleShape doit être chargée pour mettre à jour t pouvoir accéder aux donnée de la classe.");
        }
        $this->radius = Lib::getGraphicsLib()->sfCircleShape_getRadius($this->cdata);
        $this->outlineThickness = Lib::getGraphicsLib()->sfCircleShape_getOutlineThickness($this->cdata);

        $positionCData = Lib::getGraphicsLib()->sfCircleShape_getPosition($this->cdata);
        $this->position->setXPos($positionCData->x);
        $this->position->setYPos($positionCData->y);

        $fillColorCData = Lib::getGraphicsLib()->sfCircleShape_getFillColor($this->cdata);
        $this->setFillColor(
            (new Color(Color::DYNAMIC))
                ->fromRGBA($fillColorCData->r, $fillColorCData->g, $fillColorCData->b, $fillColorCData->a)
        );

        $outlineColorCData = Lib::getGraphicsLib()->sfCircleShape_getOutlineColor($this->cdata);
        $this->setOutlineColor(
            (new Color(Color::DYNAMIC))
                ->fromRGBA($outlineColorCData->r, $outlineColorCData->g, $outlineColorCData->b, $outlineColorCData->a)
        );
    }

    public function draw(Window $target): void
    {
        if (!$target->isCDataLoad()) {
            throw new CDataException("Les données C de la fenêtre n'ont pas été chargé pour pouvoir y dessiner un cercle.");
        }
        Lib::getGraphicsLib()->sfRenderWindow_drawCircleShape($target->getCData(), $this->toCData(), null);
    }
}
