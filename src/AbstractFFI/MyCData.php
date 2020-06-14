<?php


namespace PHPML\AbstractFFI;

use FFI;
use FFI\CData;
use PHPML\Exception\CDataException;

trait MyCData
{
    protected ?CData $cdata = null;

    public function __destruct()
    {
        if ($this->isCDataLoad()) {
            //FFI::free($this->cdata);
            unset($this->cdata);
        }
    }

    /**
     * Vérifie si la donnée C a déjà été chargée.
     *
     * @return bool selon que la donnée a été chargé ou non
     */
    public function isCDataLoad() : bool
    {
        return $this->cdata != null;
    }

    /**
     * Accesseur à la donnée C.
     *
     * @return CData|null
     */
    public function &getCData(): ?CData
    {
        if (!$this->isCDataLoad()) {
            $className = static::class;
            throw new CDataException("Les données C de {$className} doivent être chargées avant de pouvoir y accéder.");
        }
        return $this->cdata;
    }

    /**
     * Met à jour les attributs d'instance de la classe avec les données C chargées.
     *
     * @throws CDataException si la donnée C n'a pas été chargée
     */
    abstract protected function updateFromCData() : void;

    /**
     * Convertie l'instance actuelle en donnée C utilisable avec la bibliothèque.
     *
     * @return CData
     */
    abstract public function toCData() : CData;
}
