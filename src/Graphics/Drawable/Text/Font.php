<?php


namespace PHPML\Graphics\Drawable\Text;

use FFI\CData;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CSFMLType;
use PHPML\Exception\CDataException;
use PHPML\Library\GraphicsLibLoader as Lib;
class Font
{
    use MyCData;
    const DEFAULT_FONT = __DIR__ . '/font/Roboto-Black.ttf';

    private string $fontPath;

    /**
     * Font constructor.
     * Créé une police de caractère à utilisé pour l'affichage de texte.
     *
     * @param string $fontPath chemin vers le fichier de la police
     */
    public function __construct(string $fontPath = null)
    {
        $this->fontPath = $fontPath ?? self::DEFAULT_FONT;
        $this->toCData();
    }

    public function __destruct()
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfFont_destroy($this->cdata);
            unset($this->cdata);
        }
    }

    private function loadFromFile(string $path): self
    {
        $this->cdata = Lib::getGraphicsLib()->sfFont_createFromFile($path);
        if (\FFI::isNull($this->cdata)) {
            throw new CDataException("Erreur de chargement lors de la création de la police avec le chemin : $path.");
        }
        return $this;
    }
    protected function updateFromCData(): void
    {
        return;
    }

    public function toCData(): CData
    {
        $this->cdata ??= Lib::getGraphicsLib()->new(
            Lib::getGraphicsLib()->type(CSFMLType::FONT)
        );
        $this->loadFromFile($this->fontPath);
        return $this->cdata;
    }
}
