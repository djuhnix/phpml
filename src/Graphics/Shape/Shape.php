<?php


namespace PHPML\Graphics\Shape;

use FFI\CData;
use PHPML\Component\Vector;
use PHPML\Enum\Color;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CSFMLType;
use PHPML\Exception\CDataException;
use PHPML\Graphics\Window;
use PHPML\Library\GraphicsLibLoader as Lib;

abstract class Shape
{
    use MyCData;

    protected Vector $position;
    protected Color $fillColor;
    protected Color $outlineColor;
    protected float $outlineThickness;

    /**
     * Shape constructor.
     * Cette classe est abstraite et ne peut pas être instancié, mais les classe qui en héritent appellent ce constructeur
     * pour l'initialisation des variables par défaut pour une forme.
     *
     * @param array|int[] $position
     * @param Color|null $fillColor
     */
    public function __construct(array $position = [0, 0], Color $fillColor = null)
    {
        $this->position = new Vector(
            new CSFMLType(CSFMLType::VECTOR_2F),
            $position
        );
        $this->fillColor = $fillColor ?? new Color(Color::RED);
        $this->outlineThickness = 0;
        $this->outlineColor = $this->fillColor;
    }

    public function __destruct()
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->{$this->getTypeName().'_destroy'}($this->cdata);
            unset($this->cdata);
        }
    }

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
     * @return array le couple de coordonnées de la position
     */
    public function getPosition(): array
    {
        $this->updateFromCData();
        return $this->position->getTable();
    }

    /**
     * Modificateur de la position.
     *
     * @param array $position la nouvelle position
     */
    public function setPosition(array $position): void
    {
        $positionVector = new Vector(
            new CSFMLType(CSFMLType::VECTOR_2F),
            $position
        );
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->{$this->getTypeName().'_setPosition'}(
                $this->cdata,
                $positionVector->toCData()
            );
        }
        $this->position = $positionVector;
    }

    protected function updateFromCData(): void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de CircleShape doit être chargée pour mettre à jour t pouvoir accéder aux donnée de la classe.");
        }

        $this->outlineThickness = Lib::getGraphicsLib()->{$this->getTypeName().'_getOutlineThickness'}($this->cdata);

        $positionCData = Lib::getGraphicsLib()->{$this->getTypeName().'_getPosition'}($this->cdata);
        $this->position->set(0, $positionCData->x);
        $this->position->set(1, $positionCData->y);

        $fillColorCData = Lib::getGraphicsLib()->{$this->getTypeName().'_getFillColor'}($this->cdata);
        $this->setFillColor(
            (new Color(Color::DYNAMIC))
                ->fromRGBA(
                    $fillColorCData->r,
                    $fillColorCData->g,
                    $fillColorCData->b,
                    $fillColorCData->a
                )
        );

        $outlineColorCData = Lib::getGraphicsLib()->{$this->getTypeName().'_getOutlineColor'}($this->cdata);
        $this->setOutlineColor(
            (new Color(Color::DYNAMIC))
                ->fromRGBA(
                    $outlineColorCData->r,
                    $outlineColorCData->g,
                    $outlineColorCData->b,
                    $outlineColorCData->a
                )
        );
    }

    /**
     * @inheritDoc
     */
    public function toCData(): CData
    {
        $this->cdata ??= Lib::getGraphicsLib()->new(
            Lib::getGraphicsLib()->type($this->getTypeName())
        );
        $this->cdata = Lib::getGraphicsLib()->{$this->getTypeName().'_create'}();
        if (\FFI::isNull($this->cdata)) {
            throw new CDataException("Erreur de chargement lors de la création de la forme : " . static::class);
        }

        $this->setFillColor($this->fillColor);
        $this->setOutlineColor($this->outlineColor);
        $this->setOutlineThickness($this->outlineThickness);
        $this->setPosition($this->position->getTable());

        return $this->cdata;
    }

    /**
     * Modificateur de la couleur de remplissage.
     *
     * @param Color $fillColor nouvelle couleur
     */
    public function setFillColor(Color $fillColor): void
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->{$this->getTypeName().'_setFillColor'}(
                $this->cdata,
                $fillColor->getCDataColor()
            );
        }
        $this->fillColor = $fillColor;
    }

    /**
     * Modificateur de la couleur des bords
     *
     * @param Color $outlineColor la nouvelle couleur
     */
    public function setOutlineColor(Color $outlineColor): void
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->{$this->getTypeName().'_setOutlineColor'}(
                $this->cdata,
                $outlineColor->getCDataColor()
            );
        }
        $this->outlineColor = $outlineColor;
    }

    /**
     * Modificateur de l'épaisseur
     *
     * @param float $outlineThickness
     */
    public function setOutlineThickness(float $outlineThickness): void
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->{$this->getTypeName().'_setOutlineThickness'}(
                $this->cdata,
                $this->outlineThickness
            );
        }
        $this->outlineThickness = $outlineThickness;
    }

    /**
     * Dessine cette forme sur la fenêtre.
     *
     * @param Window $target
     */
    public function draw(Window $target) : void
    {
        if (!$target->isCDataLoad()) {
            throw new CDataException("Les données C de la fenêtre n'ont pas été chargé pour pouvoir y dessiner un cercle.");
        }
        $realTypeName = substr($this->getTypeName(), 2);
        Lib::getGraphicsLib()->{'sfRenderWindow_draw'.$realTypeName}($target->getCData(), $this->toCData(), null);
    }

    /**
     * @return string le nom du type CSFML
     */
    abstract protected function getTypeName(): string;
}
