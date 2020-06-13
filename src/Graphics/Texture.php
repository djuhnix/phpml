<?php


namespace PHPML\Graphics;

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
     * Charge une texture depuis une fichier image.
     *
     * @param string $path chemin vers le fichier à charger dans la texture
     * @param array $area la zone de l'image source à charger dans la texture (facultatif, pas encore pris en charge)
     * @return Texture la texture mise à jour avec les nouvelles données
     */
    public function loadFromFile(string $path, array $area = null): self
    {
        $this->cdata = Lib::getGraphicsLib()->sfTexture_createFromFile($path, null);
        if (\FFI::isNull($this->cdata)) {
            throw new CDataException("Erreur de chargement lors de la création de la texture avec l'image de chemin : $path.");
        }
        return $this;
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
