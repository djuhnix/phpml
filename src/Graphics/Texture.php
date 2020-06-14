<?php


namespace PHPML\Graphics;

use FFI;
use FFI\CData;
use PHPML\AbstractFFI\MyCData;
use PHPML\Component\Vector;
use PHPML\Enum\CSFMLType;
use PHPML\Exception\CDataException;
use PHPML\Library\GraphicsLibLoader as Lib;

class Texture
{
    use MyCData;

    private Vector $size;
    private bool $smooth;
    private bool $repeated;

    /**
     * Texture constructor.
     * Crée une nouvelle texture vide qui doit être chargé via les méthodes d'instance équivalentes.
     *
     * @param int $width la largeur de la texture
     * @param int $height la longeur de la texture
     */
    public function __construct(int $width, int $height)
    {
        $this->size = new Vector(
            new CSFMLType(CSFMLType::VECTOR_2U),
            [$width, $height]
        );
        $this->toCData();
    }

    public function __destruct()
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfTexture_destroy($this->cdata);
            unset($this->cdata);
        }
    }

    /**
     * Accesseur à la taille de la texture.
     *
     * @return array un couple, longueur-largeur
     */
    public function getSize(): array
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->size->getArray();
    }

    /**
     * Accesseur au lissage de la texture.
     *
     * @return bool
     */
    public function isSmooth(): bool
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->smooth;
    }

    /**
     * Redéfinie le lissage de la texture
     *
     * @param bool $smooth
     */
    public function setSmooth(bool $smooth): void
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfTexture_setSmooth(
                $this->cdata,
                $smooth
            );
        }
        $this->smooth = $smooth;
    }

    /**
     * Accesseur l'attribut définissant la répétition de la texture
     *
     * @return bool
     */
    public function isRepeated(): bool
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->repeated;
    }

    /**
     * @param bool $repeated
     */
    public function setRepeated(bool $repeated): void
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfTexture_setRepeated(
                $this->cdata,
                $repeated
            );
        }
        $this->repeated = $repeated;
    }

    /**
     * Copie d'une texture dans la texture actuelle.
     * Remplace les données C et les attributs de l'instance actuelle par celle la texture donnée en paramètre.
     *
     * @param Texture $texture la texture à copier
     */
    public function copy(Texture $texture)
    {
        $this->cdata = Lib::getGraphicsLib()->sfTexture_copy($texture->getCData());
        $this->updateFromCData();
    }

    /**
     * Charge une texture depuis une fichier image.
     *
     * @param string $path chemin vers le fichier à charger dans la texture
     * @return Texture la texture mise à jour avec les nouvelles données
     */
    public function loadFromFile(string $path): self
    {
        $this->cdata = Lib::getGraphicsLib()->sfTexture_createFromFile($path, null);
        if (\FFI::isNull($this->cdata)) {
            throw new CDataException("Erreur de chargement lors de la création de la texture avec l'image de chemin : $path.");
        }
        return $this;
    }

    /**
     * Échange les données de deux textures.
     * Cette fonction peut ne pas fonctionner comme voulu à cause du traitement de données C entre les classes.
     *
     * @param Texture $leftTexture la première texture à échanger
     * @param Texture $rightTexture la deuxième texture qui sera échangé avec la première
     */
    public static function swap(Texture &$leftTexture, Texture &$rightTexture)
    {
        Lib::getGraphicsLib()->sfTexture_swap(
            $leftTexture->getCData(),
            $rightTexture->getCData(),
        );
        $leftTexture->updateFromCData();
        $rightTexture->updateFromCData();
    }

    /**
     * Accesseur à la taille maximum de textures autorisée.
     *
     * @return int la taille maximum autorisée pour les textures en pixel
     */
    public static function getMaximumSize(): int
    {
        return Lib::getGraphicsLib()->sfTexture_getMaximumSize();
    }

    protected function updateFromCData(): void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("Les données C de Texture doivent être chargées pour mettre à jour les données de la classe.");
        }
        $sizeCData = Lib::getGraphicsLib()->sfTexture_getSize($this->cdata);
        $this->size = new Vector(
            new CSFMLType(CSFMLType::VECTOR_2U),
            [$sizeCData->x, $sizeCData->y]
        );

        $this->repeated = Lib::getGraphicsLib()->sfTexture_getRepeated($this->cdata);
        $this->smooth = Lib::getGraphicsLib()->sfTexture_getSmooth($this->cdata);
    }

    public function toCData(): CData
    {
        $this->cdata ??= Lib::getGraphicsLib()->sfTexture_create(
            $this->size->get(0),
            $this->size->get(1)
        );
        if (\FFI::isNull($this->cdata)) {
            throw new CDataException("Erreur de chargement lors de la création de la texture.");
        }

        return $this->cdata;
    }
}
