<?php


namespace PHPML\Component;

use FFI\CData;
use InvalidArgumentException;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CSFMLType;
use PHPML\Exception\CDataException;
use PHPML\Library\GraphicsLibLoader as Lib;

/**
 * Class RectArea
 * Utilisé pour manipuler facilement les rectangles.
 *
 * Attention : cette classe ne peut pas être déssiner sur une fenêtre.
 *
 * @package PHPML\Component
 */
class RectArea
{
    use MyCData;

    private float $left;
    private float $top;
    private float $width;
    private float $height;
    private CSFMLType $type;

    /**
     * RectArea constructor.
     * initialise les attributs du rectangle, les deux premiers paramètre représentent
     * les coordonnées du point en haut à gauche du rectangle, et les deux autres
     * la longueur et la largeur du rectangle
     *
     * @param CSFMLType $type
     * @param float $left coordonnée x du point en haut à gauche du rectangle
     * @param float $top coordonnée y du point en haut à gauche du rectangle
     * @param float $width largeur du rectangle
     * @param float $height longueur du rectangle
     */
    public function __construct(
        CSFMLType $type,
        float $left = 0,
        float $top = 0,
        float $width = 0,
        float $height = 0
    ) {
        if ($type->getValue() != CSFMLType::FLOAT_RECT
            && $type->getValue() != CSFMLType::INT_RECT
        ) {
            throw new InvalidArgumentException("Invalide type CSFML reçu {$type->getKey()}, attendu *_RECT");
        }
        $this->left = $left;
        $this->top = $top;
        $this->width = $width;
        $this->height = $height;
        $this->type = $type;
        $this->toCData();
    }

    /**
     * Vérifie si le point passé en paramètre est inclus dans le rectangle
     *
     * @param float $xCoord coordonnée x du point
     * @param float $yCoord coordonnée y du point
     * @return bool
     */
    public function contains(float $xCoord, float $yCoord): bool
    {
        return Lib::getGraphicsLib()->{$this->type . '_contains'}(
            \FFI::addr($this->cdata),
            $xCoord,
            $yCoord
        );
    }

    /**
     * Vérifie si deux rectangles sont en intersection
     *
     * @param RectArea $rectArea1 premier rectangle pour la vérification
     * @param RectArea $rectArea2 second rectangle pour la vérification
     * @param RectArea $intersection le rectangle qui sera rempli du résultat de l'intersection (peut être null)
     * @return bool
     */
    public static function intersects(RectArea $rectArea1, RectArea $rectArea2, RectArea $intersection = null): bool
    {
        if ($rectArea1->type->getValue() != $rectArea2->type->getValue()) {
            throw new InvalidArgumentException("Les rectangles ne sont pas du même type pour vérifier s'il y'a intersection");
        }
        if ($intersection != null && $rectArea1->type->getValue() != $intersection->type->getValue()) {
            throw new InvalidArgumentException("Le troisième rectangle passé en paramètre doit être du même type que les deux autres pour pouvoir être remplis");
        }
        $res = Lib::getGraphicsLib()->{$rectArea1->type . '_intersects'}(
            $rectArea1->getCData(),
            $rectArea2->getCData(),
            $intersection == null ? null : $intersection->getCData()
        );
        $intersection->updateFromCData();
        return $res;
    }

    /**
     * Accesseur au type C du rectangle.
     *
     * @return CSFMLType
     */
    public function getType(): CSFMLType
    {
        return $this->type;
    }


    /**
     * Accesseur à la coordonnée x du point en haut à gauche du rectangle.
     *
     * @return float|int
     */
    public function getLeft(): float
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->left;
    }

    /**
     * Modificateur de la coordonnée x du point en haut à gauche du rectangle
     *
     * @param float|int $left
     */
    public function setLeft(float $left): void
    {
        if ($this->isCDataLoad()) {
            $this->cdata->left = $left;
        }
        $this->left = $left;
    }

    /**
     * Accesseur à la coordonnée y du point en haut à gauche du rectangle.
     *
     * @return float|int
     */
    public function getTop(): float
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->top;
    }

    /**
     * Modificateur de la coordonnée y du point en haut à gauche du rectangle.
     *
     * @param float|int $top nouvelle valeur
     */
    public function setTop(float $top): void
    {
        if ($this->isCDataLoad()) {
            $this->cdata->top = $top;
        }
        $this->top = $top;
    }

    /**
     * Accesseur à la largeur du rectangle
     *
     * @return float|int
     */
    public function getWidth(): float
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->width;
    }

    /**
     * Modificateur de la largeur du rectangle
     *
     * @param float|int $width nouvelle largeur
     */
    public function setWidth(float $width): void
    {
        if ($this->isCDataLoad()) {
            $this->cdata->width = $width;
        }
        $this->width = $width;
    }

    /**
     * Accesseur à la hauteur/longueur du rectangle.
     *
     * @return float|int
     */
    public function getHeight() : float
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->height;
    }

    /**
     * Modificateur de la hauteur/longueur du rectangle.
     *
     * @param float|int $height nouvelle hauteur/longueur.
     */
    public function setHeight(float $height): void
    {
        if ($this->isCDataLoad()) {
            $this->cdata->height = $height;
        }
        $this->height = $height;
    }

    protected function updateFromCData(): void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("Les données C de RectArea doivent être chargées pour mettre à jour les donnée de la classe.");
        }
        $this->left = $this->cdata->left;
        $this->top = $this->cdata->top;
        $this->width = $this->cdata->width;
        $this->height = $this->cdata->height;
    }

    public function toCData(): CData
    {
        $this->cdata ??= Lib::getGraphicsLib()->new(
            Lib::getGraphicsLib()->type($this->type)
        );
        $this->cdata->left = $this->left;
        $this->cdata->top = $this->top;
        $this->cdata->width = $this->width;
        $this->cdata->height = $this->height;

        return $this->cdata;
    }
}
