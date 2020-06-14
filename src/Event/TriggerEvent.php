<?php

namespace PHPML\Event;

use FFI\CData;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\EventType;
use PHPML\Exception\CDataException;
use PHPML\Graphics\Event;
use PHPML\Library\GraphicsLibLoader as Lib;

abstract class TriggerEvent
{
    use MyCData;

    protected Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->cdata = $this->toCData();
    }

    /**
     * Accesseur au type de l'événement déclenché
     *
     * @return EventType
        $this->type
     */
    public function getEventType() : EventType
    {
        if (!$this->isCDataLoad()) {
            $className = static::class;
            throw new CDataException("La donnée C de {$className} doit être chargé pour mettre à jour les donnée de la classe.");
        }
        return new EventType($this->cdata->type);
    }

    /**
     * @inheritDoc
     */
    public function toCData(): CData
    {
        if (!$this->event->isCDataLoad()) {
            $className = static::class;
            throw new CDataException("La donnée C de l'événement n'est pas chargé pour avoir accès à la donnée C de {$className}");
        }
        $typeName = EventType::TRIGGERABLE[$this->getEventTypeVarName()];
        $this->cdata ??= Lib::getGraphicsLib()->new(
            Lib::getGraphicsLib()->type($typeName)
        );
        $this->cdata = $this->event->getCData()->{$this->getEventTypeVarName()};
        return $this->cdata;
    }

    /**
     * Retourne le nom de la variable du type d'événément en C.
     */
    abstract protected function getEventTypeVarName() : string;
}
