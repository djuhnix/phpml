<?php


namespace PHPML\Graphics;

use FFI\CData;
use InvalidArgumentException;
use PHPML\AbstractFFI;
use PHPML\Enum\Color;
use PHPML\Enum\CSFMLType;
use PHPML\Enum\Event;
use PHPML\Enum\WindowStyle;
use PHPML\Exception\CDataException;
use PHPML\Exception\RenderWindowException;
use PHPML\Graphics\GraphicsLibLoader as Lib;
use PHPML\Graphics\Shape\Shape;

class Window
{
    use AbstractFFI\MyCData;

    /**
     * @var Event événement de la fenêtre - gérer par la bibliothèque.
     */
    private Event $event;
    private string $title;
    private Color $backgroundColor;
    private Size $size;
    private array $options;

    /**
     * Window constructor.
     *
     * @param Size $size
     * @param string $title
     * @param array|null $options
     */
    public function __construct(Size $size, string $title = "PHPML Basic Window", array $options = null)
    {
        if (is_array($options) && !$this->isCorrectOptions($options)) {
            throw new InvalidArgumentException('Les options données ne sont pas correctes');
        }

        $this->ctype = Lib::getGraphicsLib()->type(CSFMLType::RENDER_WINDOW);
        $this->size = $size;
        $this->title = $title;
        $this->options ??= [new WindowStyle(WindowStyle::DEFAULT)];
        $this->event = (new Event(Event::LIB_MANAGED));
        $this->backgroundColor = new Color(Color::WHITE);
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        //$eventCData = $this->event->toCData();
        //Lib::getGraphicsLib()->free($eventCData);
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfRenderWindow_destroy($this->cdata);
        }
    }

    /**
     * Lance la boucle principale de la fenêtre et l'ouvre dans le même temps.
     *
     * @param callable $eventProcessing fonction de gestion d'événement
     * @param callable $drawing fonction de dessins
     */
    public function run(callable $eventProcessing = null, callable $drawing = null)
    {
        $this->cdata ??= $this->toCData();

        //Début de la boucle
        while ($this->isOpen()) {
            // Gestion des événements
            $this->handleEvent($eventProcessing);

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
     * Accesseur à la valeur de la couleur d'arrière plan.
     *
     * @return string
     */
    public function getBackgroundColorValue(): string
    {
        return $this->backgroundColor->getValue();
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
     * @return Size
     */
    public function getSize(): Size
    {
        return $this->size;
    }

    /**
     * @param Size $size
     */
    public function setSize(Size $size): void
    {
        $this->size = $size;
    }

    /**
     * Accesseur aux événements de la fenêtre
     *
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
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
            /** @var  $option WindowStyle */
            $result = $result | Lib::getGraphicsLib()->{$option->getValue()};
        }
        return $result;
    }

    /**
     * Gestion des événements
     *
     * @param callable $eventProcessing un fonction qui gère les événement dans des blocs conditionnels
     */
    public function handleEvent(callable $eventProcessing = null) : void
    {
        while ($this->pollEvent()) {
            // Ferme la fenêtre si l'événement 'close' est enregistrer
            if ($this->event->getCData()->type == Event::toCDataValue(Event::CLOSED)) {
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
        if (!$this->isCDataLoad()) {
            $this->cdata = Lib::getGraphicsLib()->new($this->ctype);
            $this->cdata = Lib::getGraphicsLib()->sfRenderWindow_create(
                $this->size->toCData(),
                $this->title,
                $this->convertOptions(),
                null // ContextSettings normalement, mais pas pris encore charge
            );
            if (\FFI::isNull($this->cdata)) {
                throw new RenderWindowException();
            }
        }

        return $this->cdata;
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
    public function pollEvent(CData $eventPointer = null) : bool
    {
        $eventPointer ??= $this->event->toCData();
        return Lib::getGraphicsLib()->sfRenderWindow_pollEvent($this->cdata, \FFI::addr($eventPointer));
    }

    /**
     * Ferme la fenêtre.
     * Veiller à ouvrir la fenêtre ou à vérifier si elle est ouverte avant d'appeler cette méthode.
     */
    public function close() : void
    {
        Lib::getGraphicsLib()->sfRenderWindow_close($this->cdata);
    }

    /**
     * Néttoie / Vide l'écran avec la couleur passée en paramètre
     *
     * @param Color $color
     */
    public function clear(Color $color) : void
    {
        Lib::getGraphicsLib()->sfRenderWindow_clear($this->cdata, $color->toCDataValue($color->getValue()));
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
