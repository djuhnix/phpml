<?php


namespace PHPML\Graphics\Drawable\Sprite;

use FFI\CData;
use PHPML\Enum\Color;
use PHPML\Enum\CSFMLType;
use PHPML\Graphics\Drawable\AbstractDrawable;
use PHPML\Graphics\Drawable\TransformableOnly;
use PHPML\Graphics\Texture;
use PHPML\Library\GraphicsLibLoader as Lib;

class Sprite extends AbstractDrawable
{
    use TransformableOnly;

    private ?Color $spriteColor;

    /**
     * Sprite constructor.
     *
     * @param Color|null $spriteColor La couleur du sprite, mettre null si vous ne voulez une couleur sur le sprite
     * @param array $position la position du sprite
     * @param Texture $texture la texture du sprite
     */
    public function __construct(?Color $spriteColor = null, array $position = [0, 0], $texture = null)
    {
        $this->spriteColor = $spriteColor;
        parent::__construct($position, null, $texture);
    }

    /**
     * Accesseur à la couleur du sprite.
     *
     * @return Color|null
     */
    public function getSpriteColor(): ?Color
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->spriteColor;
    }

    /**
     * Modificateur de la couleur du sprite.
     *
     * @param Color|null $spriteColor la nouvelle couleur
     */
    public function setSpriteColor(?Color $spriteColor): void
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfSprite_setColor(
                $this->cdata,
                $spriteColor->getCDataColor()
            );
        }
        $this->spriteColor = $spriteColor;
    }

    /**
     * @inheritDoc
     */
    protected function updateFromCData(): void
    {
        parent::updateFromCData();
        $spriteColorCData = Lib::getGraphicsLib()->sfSprite_getColor($this->cdata);
        $this->spriteColor = (new Color(Color::DYNAMIC))
            ->fromRGBA(
                $spriteColorCData->r,
                $spriteColorCData->g,
                $spriteColorCData->b,
                $spriteColorCData->a
            );
    }

    /**
     * @inheritDoc
     */
    public function toCData(): CData
    {
        $this->cdata ??= parent::toCData();
        if ($this->spriteColor != null) {
            $this->setSpriteColor($this->spriteColor);
        }

        return $this->cdata;
    }

    public function getTypeName(): string
    {
        return CSFMLType::SPRITE;
    }
}
