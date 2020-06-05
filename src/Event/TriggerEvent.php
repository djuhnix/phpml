<?php

namespace PHPML\Event;

use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\EventType;
use PHPML\Exception\CDataException;
use PHPML\Graphics\Event;

abstract class TriggerEvent
{
    use MyCData;

    protected Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Accesseur au type de l'événement déclenché
     *
     * @return EventType
     */
    public function getEventType() : EventType
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("Les donnée C doivent être chargée pour avoir le type de l'événement.");
        }
        return new EventType($this->cdata->type);
    }

    /**
     * Retourne le nom de la variable du type d'événément en C.
     */
    abstract protected function getTypeName() : string;
}
