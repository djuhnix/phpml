<?php

namespace PHPML\Graphics\Drawable\Shape;

use FFI\CData;
use PHPML\Enum\Color;
use PHPML\Enum\CSFMLType;
use PHPML\Graphics\Drawable\AbstractDrawable;
use PHPML\Graphics\Texture;
use PHPML\Library\GraphicsLibLoader as Lib;

class CircleShape extends AbstractDrawable
{
    /**
     * @var float Rayon du cercle
     */
    private float $radius;

    /**
     * CircleShape constructor.
     * @param float $radius
     * @param array $position
     * @param Color|null $fillColor
     * @param Texture $texture
     */
    public function __construct(float $radius, array $position = [0, 0], Color $fillColor = null, Texture $texture = null)
    {
        $this->radius = $radius;
        parent::__construct($position, $fillColor, $texture);
    }

    /**
     * Accesseur au rayon du cercle.
     *
     * @return float le rayon
     */
    public function getRadius(): float
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
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
    public function toCData(): CData
    {
        $this->cdata ??= parent::toCData();
        $this->setRadius($this->radius);

        return $this->cdata;
    }

    /**
     * @inheritDoc
     */
    protected function updateFromCData(): void
    {
        parent::updateFromCData();
        $this->radius = Lib::getGraphicsLib()->{$this->getTypeName().'_getRadius'}($this->cdata);
    }

    /**
     * @inheritDoc
     */
    protected function getTypeName(): string
    {
        return CSFMLType::CIRCLE_SHAPE;
    }
}
