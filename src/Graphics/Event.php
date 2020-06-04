<?php


namespace PHPML\Graphics;

use FFI;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CSFMLType;
use PHPML\Enum\EventType;
use PHPML\Exception\CDataException;
use PHPML\Graphics\GraphicsLibLoader as Lib;

class Event
{
    use MyCData;

    /**
     * Accesseur au type de l'événement contenu dans la donnée C.
     *
     * @return EventType
     */
    public function getType(): EventType
    {
        if ($this->isCDataLoad()) {
            $type = new EventType($this->cdata->type);
        } else {
            throw new CDataException("La donnée C de l'événement n'est pas chargé pour pouvoir avoir le type d'événement.");
        }
        return $type;
    }

    /**
     * Convertit l'événement en donnée C.
     * Si l'événement a déjà été convertit précédemment il est retourné.
     *
     * @throws \InvalidArgumentException si l'événement n'a pas pour valeur LIB_MANAGED
     */
    public function toCData(): FFI\CData
    {
        $this->cdata ??= Lib::getGraphicsLib()->new(
            Lib::getGraphicsLib()->type(CSFMLType::EVENT)
        );
        return $this->cdata;
    }
}
