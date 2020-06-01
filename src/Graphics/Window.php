<?php


namespace PHPML\Graphics;

use PHPML\AbstractFFI;
use PHPML\Enum\Color;
use PHPML\Enum\CSFMLType;

class Window
{
    use GraphicsLibLoader;

    private string $title;
    private Color $backgroundColor;
    private Size $size;

    /**
     * Window constructor.
     *
     * @param string $title
     */
    public function __construct(Size $size, string $title = "PHPML Basic Window")
    {
        $this->checkLibAndLoad();

        $this->ctype = $this->lib->type(CSFMLType::RENDER_WINDOW);
        $this->size = $size;
        $this->title = $title;
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

    public function toCData()
    {
        $this->cdata = $this->lib->new($this->ctype);
        $this->cdata = $this->lib->sfRenderWindow_create($this->size->toCData());
    }
}
