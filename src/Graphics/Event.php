<?php

namespace PHPML\Graphics;

use FFI;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CSFMLType;
use PHPML\Enum\EventType;
use PHPML\Event\KeyEvent;
use PHPML\Event\MouseButtonEvent;
use PHPML\Event\TriggerEvent;
use PHPML\Exception\CDataException;
use PHPML\Library\GraphicsLibLoader as Lib;

class Event
{
    use MyCData;

    private ?TriggerEvent $actualEvent;
    private EventType $type;

    /**
     * Accesseur au type de l'événement contenu dans la donnée C.
     *
     * @return EventType
     */
    public function getType(): EventType
    {
        $this->updateFromCData();
        return $this->type;
    }

    /**
     * L'événement actuellement déclenché sur la fenêtre.
     * @return TriggerEvent|null l'événement actuellement déclenché
     */
    public function getActualEvent(): ?TriggerEvent
    {
        $this->updateFromCData();
        return $this->actualEvent;
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

    protected function updateFromCData(): void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de l'événement n'est pas chargé pour pouvoir obtenir l'événement actuelle.");
        }

        $this->type = new EventType($this->cdata->type);

        switch ($this->type->getValue()) {
            case EventType::KEY_PRESSED:
            case EventType::KEY_RELEASED:
                $this->actualEvent = new KeyEvent($this);
                break;
            case EventType::MOUSE_BUTTON_PRESSED:
                $this->actualEvent = new MouseButtonEvent($this);
                break;
            default:
                $this->actualEvent = null; // événement non pris en charge
        }
    }
}
