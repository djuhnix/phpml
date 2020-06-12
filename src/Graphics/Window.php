<?php

namespace PHPML\Graphics;

use FFI\CData;
use InvalidArgumentException;
use PHPML\AbstractFFI;
use PHPML\Enum\Color;
use PHPML\Enum\CSFMLType;
use PHPML\Enum\EventType;
use PHPML\Enum\WindowStyle;
use PHPML\Exception\CDataException;
use PHPML\Exception\RenderWindowException;
use PHPML\Library\GraphicsLibLoader as Lib;
use PHPML\Graphics\Shape\Shape;
use PHPML\Graphics\IntPosition as Position;

class Window
{
    use AbstractFFI\MyCData;

    private string $title;
    private Color $backgroundColor;
    private VideoMode $mode;
    /** @var WindowStyle[] $options */
    private array $options;
    private Position $position;

    /**
     * Window constructor.
     *
     * @param VideoMode $mode
     * @param string $title
     * @param array|null $options
     * @param Color $backgroundColor
     */
    public function __construct(
        VideoMode $mode,
        string $title = "PHPML Basic Window",
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
    }

    public function __destruct()
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfRenderWindow_destroy($this->cdata);
            unset($this->cdata);
        }
    }

    /**
     * Lance la boucle principale de la fenêtre et l'ouvre dans le même temps.
     *
     * @param Event $event l'instance d'événement
     * @param callable $eventProcessing fonction de gestion d'événement
     * @param callable $drawing fonction de dessins
     */
    public function run(Event $event, callable $eventProcessing = null, callable $drawing = null)
    {
        $this->cdata ??= $this->toCData();

        //Début de la boucle
        while ($this->isOpen()) {
            // Gestion des événements
            $this->handleEvent($event, $eventProcessing);

            // Nettoyage de l'écran de la fenêtre et affichage
            $this->clear($this->backgroundColor);

            // lancement des dessins s'il y en a
            if ($drawing != null) {
                $drawing();
            }
            $this->display();
        }
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
     * @return Position
     */
    public function getPosition(): Position
    {
        $this->updateFromCData();
        return $this->position;
    }

    /**
     * @param Position $position
     */
    public function setPosition(Position $position): void
    {
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
            $result = $result | Lib::getGraphicsLib()->{$option->getValue()};
        }
        return $result;
    }

    /**
     * Gestion des événements
     *
     * @param Event $event
     * @param callable $eventProcessing un fonction qui gère les événement dans des blocs conditionnels
     */
    public function handleEvent(Event $event, callable $eventProcessing = null) : void
    {
        while ($this->pollEvent($event->toCData())) {
            // Ferme la fenêtre si l'événement 'close' est enregistrer
            if ($event->getType()->getValue() == EventType::CLOSED) {
                $this->close();
            }

            //Appelle la fonction de gestion d'événement
            if ($eventProcessing != null) {
                $eventProcessing();
            }
        }
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
        $this->position->setXPos($positionCData->x);
        $this->position->setYPos($positionCData->y);
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


    /**
     * @param Shape $shape
     */
    public function draw(Shape $shape) : void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de la de la fenêtre doit être prête(chargé) pour pourvoir y dessiner.");
        }
        $shape->draw($this);
    }
}
