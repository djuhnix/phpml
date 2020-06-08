<?php

namespace PHPML\Event;

use FFI\CData;
use PHPML\Enum\CSFMLType;
use PHPML\Enum\EventType;
use PHPML\Enum\MouseButton;
use PHPML\Exception\CDataException;
use PHPML\Graphics\Event;
use PHPML\Library\LibLoader as Lib;

/**
 * Class MouseButtonEvent
 * Instanciée dynamiquement par la classe Event
 *
 * @package PHPML\Event
 */
class MouseButtonEvent extends TriggerEvent
{
    /**
     * MouseButtonEvent constructor.
     *
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        parent::__construct($event);
        $this->cdata = $this->toCData();
    }

    /**
     * @return MouseButton|null
     */
    public function getMouseButton(): ?MouseButton
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de l'événement n'est pas chargé pour avoir accès à l'attribut MouseButton de MouseButtonEvent");
        }
        return new MouseButton($this->cdata->button);
    }

    /**
     * @return float|null
     */
    public function getXCoord(): ?float
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de l'événement n'est pas chargé pour avoir accès à l'attribut X de MouseButtonEvent");
        }
        return $this->cdata->x;
    }

    /**
     * @return float|null
     */
    public function getYCoord(): ?float
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de l'événement n'est pas chargé pour avoir accès à l'attribut Y de MouseButtonEvent");
        }
        return $this->cdata->y;
    }

    /**
     * @inheritDoc
     * @param Event $event l'événement associé
     */
    public function toCData(): CData
    {
        if (!$this->event->isCDataLoad()) {
            throw new CDataException("La donnée C de l'événement n'est pas chargé pour avoir accès à la donnée C de MouseButton");
        }
        $this->cdata ??= Lib::getGraphicsLib()->new(
            Lib::getGraphicsLib()->type(CSFMLType::MOUSE_BUTTON_EVENT)
        );
        $this->cdata = $this->event->getCData()->{$this->getTypeName()};
        return $this->cdata;
    }

    /**
     * Retourne le nom de la variable du type d'événément en C.
     */
    protected function getTypeName() : string
    {
        return 'mouseButton';
    }

}
