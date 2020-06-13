<?php


namespace PHPML\Graphics\Drawable\Text;

use FFI\CData;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\Color;
use PHPML\Enum\CSFMLType;
use PHPML\Enum\TextStyle;
use PHPML\Library\GraphicsLibLoader as Lib;
use PHPML\Graphics\Drawable\Drawable;

class Text extends Drawable
{
    use MyCData;

    private Font $font;
    private string $textString;
    private string $unicodeString;
    private int $characterSize = 0;
    /**
     * @var array|null
     */
    private ?array $textStyle;
    /**
     * @var Color
     */
    private Color $textColor;

    /**
     * Text constructor.
     * @param string $textString
     * @param string|null $fontPath
     * @param array|null $textStyles
     */
    public function __construct(
        string $textString,
        Color $textColor,
        string $fontPath = null,
        array $textStyles = null
    ) {
        if (is_array($textStyles) && !$this->isCorrectStyles($textStyles)) {
            throw new \InvalidArgumentException("Le tableau de style de texte donné n'est pas correct.");
        }
        $this->font = new Font($fontPath);
        $this->textColor = $textColor;
        $this->textString = $textString;
        $this->textStyle = $textStyles;
        parent::__construct();
    }

    /**
     * Vérifie que les style passées sont correctes, c'est à dire des instances de TextStyle
     *
     * @param array $options les options à vérifier
     * @return bool selon que les options sont correctes ou pas
     */
    private function isCorrectStyles(array $options): bool
    {
        $ret = true;
        foreach ($options as $option) {
            if (!($option instanceof TextStyle)) {
                $ret = false;
            }
        }
        return $ret;
    }

    /**
     * Convertie les options de la fenêtre en valeur binaire utilisable dans avec la bibliothèque.
     *
     * @return int le résultat de la conversion
     */
    private function convertStyles(): int
    {
        $result = 0;
        foreach ($this->textStyle as $style) {
            $result = $result | TextStyle::toCDataValue($style->getValue());
        }
        return $result;
    }

    /**
     * Accesseur à la police de caractère
     *
     * @return Font
     */
    public function getFont(): Font
    {
        return $this->font;
    }

    /**
     * Modificateur de la police du texte à afficher.
     *
     * @param Font $font nouvelle police
     */
    public function setFont(Font $font)
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfText_setFont(
                $this->cdata,
                $font->getCData()
            );
        }
        $this->font = $font;
    }

    /**
     * Accesseur à la chaine de caractère affiché sur l'objet textuelle
     *
     * @return string
     */
    public function getTextString(): string
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->textString;
    }

    /**
     * Modifie la chaine de caractère à afficher sur l'objet textuelle
     *
     * @param string $textString le nouveau texte
     */
    public function setTextString(string $textString)
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfText_setString(
                $this->cdata,
                $textString
            );
        }
        $this->textString = $textString;
    }

    /**
     * Accesseur à la couleur actuelle du texte.
     *
     * @return Color
     */
    public function getTextColor(): Color
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->textColor;
    }

    /**
     * Modifie la couleur du texte, contrairement à @see Text::setFillColor() qui modifie la couleur de remplissage
     *
     * @param Color $textColor la nouvelle couleur
     */
    public function setTextColor(Color $textColor): void
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfText_setColor(
                $this->cdata,
                $textColor->getCDataColor()
            );
        }
        $this->textColor = $textColor;
    }

    /**
     * Accesseur à la taille de caractère du texte.
     *
     * @return int
     */
    public function getCharacterSize(): int
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->characterSize;
    }

    /**
     * Modifie la taille du texte
     *
     * @param int $charSize la nouvelle taille du texte, en pixel
     */
    public function setCharacterSize(int $charSize)
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfText_setCharacterSize(
                $this->cdata,
                $charSize
            );
        }
        $this->characterSize = $charSize;
    }

    protected function getTypeName(): string
    {
        return CSFMLType::TEXT;
    }

    protected function updateFromCData(): void
    {
        parent::updateFromCData();
        $this->textString = Lib::getGraphicsLib()->sfText_getString($this->cdata);
        $this->characterSize = Lib::getGraphicsLib()->sfText_getCharacterSize($this->cdata);

        $textColorCData = Lib::getGraphicsLib()->sfText_getColor($this->cdata);
        $this->setTextColor(
            (new Color(Color::DYNAMIC))
                ->fromRGBA(
                    $textColorCData->r,
                    $textColorCData->g,
                    $textColorCData->b,
                    $textColorCData->a
                )
        );
    }

    public function toCData(): CData
    {
        // TODO: Implement toCData() method.
        $this->setFont($this->font);
        $this->setTextString($this->textString);
        $this->setTextColor($this->textColor);
        if ($this->characterSize != 0) {
            $this->setCharacterSize($this->characterSize);
        }

        return parent::toCData();
    }
}
