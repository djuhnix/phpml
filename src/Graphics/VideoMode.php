<?php

namespace PHPML\Graphics;

use FFI\CData;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CSFMLType;
use PHPML\Exception\CDataException;
use PHPML\Library\GraphicsLibLoader as GraphicsLib;
use PHPML\Library\WindowLibLoader as WindowLib;

class VideoMode
{
    use MyCData;

    private int $width;
    private int $height;

    /**
     * Size constructor.
     *
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width = 0, int $height = 0)
    {
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
        $this->updateFromCData();
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
        if ($this->isCDataLoad()) {
            $this->cdata->width = $width;
        }
        $this->width = $width;
    }

    /**
     * Accesseur à la hauteur.
     *
     * @return int
     */
    public function getHeight(): int
    {
        $this->updateFromCData();
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
        if ($this->isCDataLoad()) {
            $this->cdata->height = $height;
        }
        $this->height = $height;
    }

    /**
     * @inheritDoc
     */
    public function toCData() : CData
    {
        $this->cdata ??= GraphicsLib::getGraphicsLib()->new(
            GraphicsLib::getGraphicsLib()->type(CSFMLType::VIDEO_MODE)
        );

        if ($this->width == 0 && $this->height == 0) {
            $this->cdata = WindowLib::getWindowLib()->sfVideoMode_getDesktopMode();
        } else {
            $this->cdata->width = $this->width;
            $this->cdata->height = $this->height;
            $this->cdata->bitsPerPixel = 32;
        }

        return $this->cdata;
    }

    protected function updateFromCData(): void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("Les données C de VideoMode doivent être chargées pour mettre à jour les donnée de la classe.");
        }
    }
}
