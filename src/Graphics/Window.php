<?php


namespace PHPML\Graphics;

use FFI\CData;
use InvalidArgumentException;
use PHPML\AbstractFFI;
use PHPML\Enum\Color;
use PHPML\Enum\CSFMLType;
use PHPML\Enum\WindowStyle;
use PHPML\Exception\RenderWindowException;

class Window
{
    use GraphicsLibLoader;

    private string $title;
    private Color $backgroundColor;
    private Size $size;
    private ?array $options;

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
        if (!$this->isCorrectOptions($options)) {
            throw new InvalidArgumentException('Les options données ne sont pas correctes');
        }

        $this->ctype = $this->lib->type(CSFMLType::RENDER_WINDOW);
        $this->size = $size;
        $this->title = $title;
        $this->options = $options;
        $this->backgroundColor = new Color(Color::WHITE);
    }

    public function run(callable $drawing)
    {
        //TODO
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
     * @param array|null $options
     * @throws InvalidArgumentException si les options entrées ne sont pas correctes
     */
    public function setOptions(?array $options): void
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
        $this->cdata = $this->lib->new($this->ctype);
        $this->cdata = $this->lib->sfRenderWindow_create(
            $this->size->toCData(),
            $this->title,
            $this->convertOptions(),
            null // ContextSettings normalement, mais pas pris encore charge
        );
        if (\FFI::isNull($this->cdata)) {
            throw new RenderWindowException();
        }
        return $this->cdata;
    }
}
