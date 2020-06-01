<?php


namespace PHPML\Graphics;

use FFI\CData;
use PHPML\AbstractFFI;
use PHPML\Enum\CSFMLType;
use PHPML\Exception\FFILoadingException;

class Size
{
    use GraphicsLibLoader;

    private int $width;
    private int $height;

    /**
     * Size constructor.
     *
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width, int $height)
    {
        $this->checkLibAndLoad();

        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Accesseur à la largeur.
     *
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * Modificateur de la largeur.
     * Dans le cas où cette méthode est appelé pour échanger avec la librairie C,
     * la donnée C doit être rechargé avec la méthode toCData pour prendre effet.
     *
     * @param int $width
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    /**
     * Accesseur à la hauteur.
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * Modificateur de la hauteur.
     * Dans le cas où cette méthode est appelé pour échanger avec la librairie C,
     * la donnée C doit être rechargé avec la méthode toCData pour prendre effet.
     *
     * @param int $height la nouvelle hauteur.
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function toCData() : CData
    {
        $this->cdata = $this->lib->new(CSFMLType::VIDEO_MODE);
        $this->cdata->width = $this->width;
        $this->cdata->height = $this->height;
        $this->cdata->bitsPerPixel = 32;

        return $this->cdata;
    }
}
