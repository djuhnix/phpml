<?php


namespace PHPML\Graphics;

use FFI\CData;
use InvalidArgumentException;
use PHPML\AbstractFFI;
use PHPML\Enum\Color;
use PHPML\Enum\CSFMLType;
use PHPML\Enum\Event;
use PHPML\Enum\WindowStyle;
use PHPML\Exception\RenderWindowException;

class Window
{
    use GraphicsLibLoader;

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
        $this->checkLibAndLoad();
        if (is_array($options) && !$this->isCorrectOptions($options)) {
            throw new InvalidArgumentException('Les options données ne sont pas correctes');
        }

        $this->ctype = $this->lib->type(CSFMLType::RENDER_WINDOW);
        $this->size = $size;
        $this->title = $title;
        $this->options ??= [WindowStyle::DEFAULT()];
        $this->event = (new Event(Event::LIB_MANAGED))->getLibManagedEvent();
        $this->backgroundColor = new Color(Color::WHITE);
    }

    /**
     * Lance la boucle principale de la fenêtre et l'ouvre dans le même temps.
     *
     * @param callable $drawing fonction de dessins
     */
    public function run(callable $drawing = null)
    {
        $this->cdata ??= $this->toCData();

        $event = $this->event->toCData();
        /*Début de la boucle */
        while ($this->lib->sfRenderWindow_isOpen($this->cdata)) {
            /* Gestion des événements */
            while ($this->lib->sfRenderWindow_pollEvent($this->cdata, \FFI::addr($event))) {

                /* Ferme la fenêtre si l'événement 'close' est enregistrer */
                if ($event->type == $this->lib->{Event::CLOSED}) {
                    $this->lib->sfRenderWindow_close($this->cdata);
                }

                // lancement des dessins s'il y en a
                if ($drawing != null) {
                    $drawing();
                }
            }

            /* Nettoyage de l'écran de la fenêtre et affichage */
            $this->lib->sfRenderWindow_clear($this->cdata, $this->lib->{$this->backgroundColor->getValue()});
            $this->lib->sfRenderWindow_display($this->cdata);
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
            $result = $result | $this->lib->{$option->getValue()};
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toCData() : CData
    {
        if(!$this->isCDataLoad()) {
            $this->cdata = $this->lib->new($this->ctype, false);
            $this->cdata = $this->lib->sfRenderWindow_create(
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
}
