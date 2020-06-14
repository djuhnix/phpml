<?php


namespace PHPML\Graphics;

use FFI\CData;
use InvalidArgumentException;
use PHPML\AbstractFFI\MyCData;
use PHPML\Component\Vector;
use PHPML\Enum\Color;
use PHPML\Enum\CSFMLType;
use PHPML\Enum\WindowStyle;
use PHPML\Exception\CDataException;
use PHPML\Exception\RenderWindowException;
use PHPML\Graphics\Drawable\AbstractDrawable;
use PHPML\Library\GraphicsLibLoader as Lib;

/**
 * Class Window
 * Contient les fonctions nécessaire pour la gestion d'une fenêtre
 * @package PHPML\Graphics
 */
class Window
{
    use MyCData;

    /** @var WindowStyle[] $options */
    private array $options;
    private string $title;
    private Color $backgroundColor;
    private VideoMode $mode;
    private Vector $position;

    public function __construct(
        VideoMode $mode,
        string $title,
        array $options = null,
        Color $backgroundColor = null
    ) {
        if (is_array($options) && !$this->isCorrectOptions($options)) {
            throw new InvalidArgumentException('Les options données ne sont pas correctes');
        }
        $this->mode = $mode;
        $this->title = $title;
        $this->options ??= [new WindowStyle(WindowStyle::DEFAULT)];
        $this->backgroundColor = $backgroundColor ?? new Color(Color::WHITE);
        $this->toCData();
    }

    /**
     * Accesseur à la couleur d'arrière plan.
     *
     * @return Color
     */
    public function getBackgroundColor(): Color
    {
        return $this->backgroundColor;
    }

    /**
     * Modificateur de la couleur d'arriere plan.
     *
     * @param Color $backgroundColor nouvelle couleur
     */
    public function setBackgroundColor(Color $backgroundColor): void
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * Accesseur à l'attribut size de la fenêtre.
     *
     * @return VideoMode
     */
    public function getMode(): VideoMode
    {
        return $this->mode;
    }

    /**
     * @param VideoMode $mode
     */
    public function setMode(VideoMode $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * Vérifie que les options passées sont correctes, c'est à dire des instances de WindowStyle
     *
     * @param array $options les options à vérifier
     * @return bool selon que les options sont correctes ou pas
     */
    private function isCorrectOptions(array $options): bool
    {
        $ret = true;
        foreach ($options as $option) {
            if (!($option instanceof WindowStyle)) {
                $ret = false;
            }
        }
        return $ret;
    }

    /**
     * Accesseur à la position de la fenêtre;
     *
     * @return array
     */
    public function getPosition(): array
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->position->getArray();
    }

    /**
     * Modification de la position actuelle de la fenêtre
     *
     * @param array $position un couple de coordonnées
     */
    public function setPosition(array $position): void
    {
        $position = new Vector(
            new CSFMLType(CSFMLType::VECTOR_2I),
            $position
        );
        Lib::getGraphicsLib()->sfRenderWindow_setPosition(
            $this->cdata,
            $position->toCData()
        );
        $this->position = $position;
    }

    /**
     * @return array|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @throws InvalidArgumentException si les options entrées ne sont pas correctes
     */
    public function setOptions(array $options): void
    {
        if (!$this->isCorrectOptions($options)) {
            throw new InvalidArgumentException('Les options données ne sont pas correctes');
        }
        $this->options = $options;
    }

    /**
     * Convertie les options de la fenêtre en valeur binaire utilisable dans avec la bibliothèque.
     *
     * @return int le résultat de la conversion
     */
    private function convertOptions(): int
    {
        $result = 0;
        foreach ($this->options as $option) {
            $result = $result | WindowStyle::toCDataValue($option->getValue());
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toCData() : CData
    {
        $this->cdata ??= Lib::getGraphicsLib()->new(
            Lib::getGraphicsLib()->type(CSFMLType::RENDER_WINDOW)
        );
        $this->cdata = Lib::getGraphicsLib()->sfRenderWindow_create(
            $this->mode->toCData(),
            $this->title,
            $this->convertOptions(),
            null // ContextSettings normalement, mais pas encore pris en charge
        );
        if (\FFI::isNull($this->cdata)) {
            throw new RenderWindowException();
        }

        return $this->cdata;
    }

    /**
     * @inheritDoc
     */
    protected function updateFromCData(): void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("Les données C de Window doivent être chargées pour mettre à jour les données de la classe.");
        }
        $positionCData = Lib::getGraphicsLib()->sfRenderWindow_getPosition($this->cdata);
        $this->position->set(0, $positionCData->x);
        $this->position->set(1, $positionCData->y);
    }

    /**
     * Dessine un objet sur une fenêtre
     * L'objet n'est pas attaché à la fenêtre et ne pourra pas être modifier plus tard,
     * de plus toute modification apportée à l'objet plus tard ne seront pas appliqué à l'objet dessiné
     *
     * @param AbstractDrawable $drawable
     */
    public function draw(AbstractDrawable $drawable) : void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de la de la fenêtre doit être prête(chargé) pour pourvoir y dessiner.");
        }
        $drawable->draw($this);
    }

    /*------------------
     * Méthodes CSFML
     *------------------
     */

    /**
     * Vérifie si la fenêtre est ouverte.
     *
     * @return bool si la fenêtre est ouverte ou pas
     */
    public function isOpen() : bool
    {
        return Lib::getGraphicsLib()->sfRenderWindow_isOpen($this->cdata);
    }
    /*
    public function hasFocus() : bool
    {
        return Lib::getGraphicsLib()->sfRenderWindow_hasFocus($this->cdata);
    }
    */
    /**
     * Convertit les coordonnées d'un point en pixel en des coordonnées du monde 2D
     *
     * @param array $point les  coordonnées d'un point à convertir
     * @return array un couple des coordonnées converties
     */
    public function mapPixelToCoords(array $point): array
    {
        $pointVector = new Vector(
            new CSFMLType(CSFMLType::VECTOR_2I),
            $point
        );
        $view = $this->cdata->CurrentView;
        $convertedPoint = Lib::getGraphicsLib()->sfRenderWindow_mapPixelToCoords(
            $this->cdata,
            $pointVector->getCData(),
            null
        );
        return [$convertedPoint->x, $convertedPoint->y];
    }

    /**
     * Vérifie s'il y'a des événement dans la file d'attente.
     *
     * @param CData|null $eventPointer
     * @return bool
     */
    public function pollEvent(CData $eventPointer) : bool
    {
        return Lib::getGraphicsLib()->sfRenderWindow_pollEvent($this->cdata, \FFI::addr($eventPointer));
    }

    /**
     * Ferme la fenêtre.
     * Veiller à ouvrir la fenêtre ou à vérifier si elle est ouverte avant d'appeler cette méthode.
     */
    public function close() : void
    {
        if (!$this->isOpen()) {
            throw new RenderWindowException("Impossible de fermer la fenêtre si elle n'est pas ouverte.");
        }
        Lib::getGraphicsLib()->sfRenderWindow_close($this->cdata);
    }

    /**
     * Nettoie / Vide l'écran avec la couleur passée en paramètre
     *
     * @param Color $color
     */
    public function clear(Color $color) : void
    {
        Lib::getGraphicsLib()->sfRenderWindow_clear($this->cdata, $color->getCDataColor());
    }

    /**
     * Affiche sur l'écran de la fenêtre ce qui a été dessiné | rendue à l'écran.
     * Cette méthode est théoriquement appelé après une action de dessin ou équivalente.
     * Veiller à ce que la fenêtre soit active avant d'appeler cette méthode.
     */
    public function display() : void
    {
        Lib::getGraphicsLib()->sfRenderWindow_display($this->cdata);
    }
}
