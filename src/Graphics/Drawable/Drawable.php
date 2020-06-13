<?php


namespace PHPML\Graphics\Drawable;

use FFI\CData;
use PHPML\AbstractFFI\MyCData;
use PHPML\Component\Vector;
use PHPML\Enum\Color;
use PHPML\Enum\CSFMLType;
use PHPML\Exception\CDataException;
use PHPML\Graphics\Texture;
use PHPML\Graphics\ExtendedWindow;
use PHPML\Library\GraphicsLibLoader as Lib;

abstract class Drawable
{
    use MyCData;

    private const MOVE      = 'move';
    private const SCALE     = 'scale';
    private const ROTATE    = 'rotate';

    private ?Texture $texture;

    protected Vector $position;
    protected ?Color $fillColor;
    protected ?Color $outlineColor;
    protected float $outlineThickness = 0;

    /**
     * Shape constructor.
     * Cette classe est abstraite et ne peut pas être instancié, mais les classe qui en héritent appellent ce constructeur
     * pour l'initialisation des variables par défaut pour une forme.
     *
     * @param array|int[] $position
     * @param Color|null $fillColor
     * @param Texture $texture
     */
    public function __construct(array $position = [0, 0], Color $fillColor = null, Texture $texture = null)
    {
        $this->position = new Vector(
            new CSFMLType(CSFMLType::VECTOR_2F),
            $position
        );

        $this->texture = $texture;
        $this->fillColor = $fillColor;
        $this->outlineColor = $fillColor;
        $this->toCData();
    }

    public function __destruct()
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->{$this->getTypeName().'_destroy'}($this->cdata);
            unset($this->cdata);
        }
    }

    /**
     * Ajoute une rotation à la forme.
     * La rotation est additionnée aux transformations déjà exécuter sur la forme.
     *
     * @param float $angle angle de rotation
     */
    public function rotate(float $angle)
    {
        $this->scaleMoveOrRotate(self::ROTATE, $angle);
    }

    /**
     * Applique une échelle à l'objet actuelle.
     * Contrairement à @see Drawable::setScale cette méthode multiplie la currente échelle de l'objet.
     *
     * @param array $factors facteur d'échelle
     */
    public function scale(array $factors): void
    {
        $this->scaleMoveOrRotate(self::SCALE, $factors);
    }

    /**
     * Déplace une forme.
     * Cette fonction repositionne la forme à la position actuelle additionnée à celle passée en paramètre.
     *
     * @param array $offset décalage x-y, les valeurs seront additionnées à la position actuelles
     */
    public function move(array $offset): void
    {
        $this->scaleMoveOrRotate(self::MOVE, $offset);
    }

    /**
     * Exécute une transformation d'échelle ou de rotation sur l'objet ou encore le déplace,
     * selon l'action donnée au premier paramètre.
     *
     * @param string $action l'action à exécuter sur l'objet : 'move', 'scale' ou 'rotate'
     * @param array|float $args l'argument lié à l'action, un couple de deux valeur flottante équivalent soit au facteur d'échelle
     * soit au décalage x-y, ou une seule valeur flottante correspondant à l'angle de rotation
     */
    private function scaleMoveOrRotate(string $action, $args)
    {
        if ($action != 'scale' && $action != 'move') {
            throw new \InvalidArgumentException("La fonction scaleOrMove ne prend que 'scale' ou 'move' en tant que premier paramètre, reçu : '$action'.");
        }
        if (!$this->isCDataLoad()) {
            throw new \InvalidArgumentException("Les données C de la classe " . static::class . " n'ont pas été chargées pour pouvoir appliquer l'action $action sur la forme.");
        }
        if (is_array($args)) {
            $argsVector = new Vector(
                new CSFMLType(CSFMLType::VECTOR_2F),
                $args
            );
            Lib::getGraphicsLib()->{$this->getTypeName().'_'.$action}(
                $this->cdata,
                $argsVector->toCData()
            );
        } elseif (is_float($args)) {
            Lib::getGraphicsLib()->{$this->getTypeName().'_'.$action}(
                $this->cdata,
                $args
            );
        } else {
            throw new \InvalidArgumentException("Le deuxième paramètre donné pour la transformation de l'objet n'est pas valide, un tableau ou un float est attendu.");
        }

        $this->updateFromCData();
    }

    /**
     * Accesseur à la couleur de remplissage
     *
     * @return Color|null
     */
    public function getFillColor(): ?Color
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->fillColor;
    }

    /**
     * Accesseur à la couleur des bords
     *
     * @return Color
     */
    public function getOutlineColor(): ?Color
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->outlineColor;
    }

    /**
     * Accesseur à l'épaisseur
     *
     * @return float
     */
    public function getOutlineThickness(): float
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->outlineThickness;
    }

    /**
     * Accesseur à la position.
     *
     * @return array le couple de coordonnées de la position
     */
    public function getPosition(): array
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->position->getArray();
    }

    /**
     * Accesseur à la texture
     *
     * @return Texture|null
     */
    public function getTexture(): ?Texture
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->texture;
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
            throw new CDataException("Les données C de CircleShape doivent être chargées pour mettre à jour les données de la classe.");
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
        $this->setPosition($this->position->getArray());
        $this->setOutlineThickness($this->outlineThickness);

        if ($this->outlineColor != null) {
            $this->setOutlineColor($this->outlineColor);
        }
        if ($this->fillColor != null) {
            $this->setFillColor($this->fillColor);
        }
        if ($this->texture != null) {
            $this->setTexture($this->texture);
        }

        return $this->cdata;
    }

    /**
     * @inheritDoc
     */
    public function setTexture(Texture $texture, bool $resetRect = true): void
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->{$this->getTypeName() . '_setTexture'}(
                $this->cdata,
                $texture->getCData(),
                $resetRect
            );
        }
        $this->texture = $texture;
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
     * @param ExtendedWindow $target
     */
    public function draw(ExtendedWindow $target) : void
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