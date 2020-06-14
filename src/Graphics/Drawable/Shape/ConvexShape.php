<?php


namespace PHPML\Graphics\Drawable\Shape;

use FFI\CData;
use PHPML\Component\Vector;
use PHPML\Enum\CSFMLType;
use PHPML\Graphics\Drawable\AbstractDrawable;
use PHPML\Library\GraphicsLibLoader as Lib;

/**
 * Class ConvexShape
 * Utile pour créer des formes convexes avec un nombre de points défini
 *
 * @todo Cette classe n'est pas achevé car les formes créer ne s'affiche pas
 * @package PHPML\Graphics\Drawable\Shape
 */
class ConvexShape extends AbstractDrawable
{
    private bool $pointCountSet = false;
    private int $pointCount;
    private array $pointArray;

    public function __construct(
        int $pointCount,
        array $pointArray
    ) {
        if ($pointCount < 0) {
            throw new \InvalidArgumentException("Le nombre de point total doit être supérieur à 0.");
        }

        for ($i = 0; $i < $pointCount; $i++) {
            if (!is_array($pointArray) && count($pointArray[$i]) != 2) {
                throw new \InvalidArgumentException("La taille du tableau contenant la position d'un point doit être égale 2, le tableau à la position $i n'est pas correcte.");
            }
        }
        $this->pointArray = $pointArray;
        $this->pointCount = $pointCount;
        parent::__construct();
    }

    /**
     * Défini le nombre de point total de la forme,
     * cette méthode doit être appeler avant @param int $pointCount le nombre de point total de la forme
     *@see ConvexShape::setPoint()
     *
     */
    public function setPointCount(int $pointCount): void
    {
        if (!$this->isCDataLoad()) {
            throw new \InvalidArgumentException("Les données C de l'objet n'ont pas été chargée pour pouvoir modifier son nombre de points total.");
        }
        Lib::getGraphicsLib()->sfConvexShape_setPointCount(
            $this->cdata,
            $pointCount
        );
        $this->pointCountSet = true;
    }

    public function getPoint(int $index): array
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return parent::getPoint($index);
    }

    /**
     * Défini la position d'un point de la forme,
     * La forme doit rester convexe et les points ordonné.
     *
     * @param int $index L'indice du point à définir doit être compris entre 0 et le nombre de point maximum défini - 1, il est important de définir les points dans l'ordre
     * @param array $position les coordonnées x et y de la position du point
     */
    public function setPoint(int $index, array $position)
    {
        if (!$this->pointCountSet) {
            throw new \InvalidArgumentException("La méthode setPoint ne peut pas être appeler avant d'avoir défini le nombre total de point via la méthode setPointCount");
        }
        if ($index < 0 && $index > $this->getPointCount() - 1) {
            throw new \InvalidArgumentException("L'indice du point à accéder doit être compris entre 0 et {$this->getPointCount()} - 1 : $index reçu.");
        }
        $positionVector = new Vector(
            new CSFMLType(CSFMLType::VECTOR_2F),
            $position
        );
        Lib::getGraphicsLib()->sfConvexShape_setPoint(
            $this->cdata,
            $index,
            $positionVector->getCData()
        );
        $this->pointArray[$index] = $position;
    }

    protected function updateFromCData(): void
    {
        parent::updateFromCData();
        for ($i = 0; $i < $this->pointCount; $i++) {
            $this->pointArray[$i] = parent::getPoint($i);
        }
    }

    /**
     * @inheritDoc
     */
    public function toCData(): CData
    {
        $this->cdata ??= parent::toCData();
        $this->setPointCount($this->pointCount);
        for ($i = 0; $i < $this->pointCount; $i++) {
            $this->setPoint($i, $this->pointArray[$i]);
        }
        return $this->cdata;
    }

    /**
     * @inheritDoc
     */
    protected function getTypeName(): string
    {
        return CSFMLType::CONVEX_SHAPE;
    }
}
