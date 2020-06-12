<?php

namespace PHPML\Graphics\Drawable\Shape;

use FFI\CData;
use PHPML\Component\Vector;
use PHPML\Enum\Color;
use PHPML\Enum\CSFMLType;
use PHPML\Library\GraphicsLibLoader as Lib;

class RectangleShape extends Shape
{
    /**
     * @var Vector Taille du rectangle, longueur et largeur
     */
    private Vector $size;

    /**
     * CircleShape constructor.
     *
     * @param array $size un tableau contenant la largeur et la longueur du rectangle
     * @param array $position un couple de coordonnées
     * @param Color|null $fillColor la couleur de remplissage
     */
    public function __construct(array $size = [10, 20], array $position = [0, 0], Color $fillColor = null)
    {
        $this->size = new Vector(
            new CSFMLType(CSFMLType::VECTOR_2F),
            $size
        );
        parent::__construct($position, $fillColor);
    }

    /**
     * @inheritDoc
     */
    protected function getTypeName(): string
    {
        return CSFMLType::RECTANGLE_SHAPE;
    }

    /**
     * Accesseur à la taille du rectangle.
     *
     * @return array un couple contenant la longueur et la largeur du rectangle
     */
    public function getSize(): array
    {
        $this->updateFromCData();
        return $this->size->getTable();
    }

    /**
     * Modificateur de la taille du rectangle.
     *
     * @param array un couple contenant la longueur et la largeur du rectangle
     */
    public function setSize(array $size): void
    {
        $sizeVector = new Vector(
            new CSFMLType(CSFMLType::VECTOR_2F),
            $size
        );
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfRectangleShape_setSize(
                $this->cdata,
                $sizeVector->toCData()
            );
        }
        $this->size = $sizeVector;
    }

    /**
     * @inheritDoc
     */
    public function toCData(): CData
    {
        $this->cdata = parent::toCData();
        $this->setSize($this->size->getTable());

        return $this->cdata;
    }

    protected function updateFromCData(): void
    {
        parent::updateFromCData();
        $this->setSize(
            Lib::getGraphicsLib()->{$this->getTypeName().'_getSize'}($this->cdata)
        );
    }
}
