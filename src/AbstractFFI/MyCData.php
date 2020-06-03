<?php


namespace PHPML\AbstractFFI;

use FFI;
use FFI\CData;
use FFI\CType;

trait MyCData
{
    protected ?CData $cdata = null;
    protected ?CType $ctype = null;

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
    public function getCData(): ?CData
    {
        return $this->cdata;
    }

    /**
     * Convertie l'instance actuelle en donnée C utilisable avec la bibliothèque.
     *
     * @return CData
     */
    abstract public function toCData() : CData;
}