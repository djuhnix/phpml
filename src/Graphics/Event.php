<?php


namespace PHPML\Graphics;

use FFI;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CSFMLType;
use PHPML\Enum\EventType;
use PHPML\Event\ITriggerable;
use PHPML\Exception\CDataException;
use PHPML\Graphics\GraphicsLibLoader as Lib;

class Event
{
    use MyCData;

    private ITriggerable $actualEvent;

    /**
     * Accesseur au type de l'événement contenu dans la donnée C.
     *
     * @return EventType
     */
    public function getType(): EventType
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de l'événement n'est pas chargé pour pouvoir avoir le type d'événement.");
        }

        return  new EventType($this->cdata->type);
    }

    /**
     * L'événement actuellement déclenché sur la fenêtre.
     *
     */
    public function getActualEvent(): ?FFI\CData
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de l'événement n'est pas chargé pour pouvoir obtenir l'événement actuelle.");
        }
        $actualEvent = null;

        foreach (EventType::TRIGGERABLE as $key => $item) {
            if (!FFI::isNull($this->cdata->{$key})
                && (
                    FFI::typeof($this->cdata->{$key})
                    === Lib::getGraphicsLib()->type($item)
                )
            ) {
                $actualEvent = $this->cdata->{$key};
                break; // probablement à changer
            }
        }

        return $actualEvent;
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
