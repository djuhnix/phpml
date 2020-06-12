<?php

namespace PHPML\Event;

use FFI\CData;
use PHPML\Enum\MouseButton;
use PHPML\Exception\CDataException;
use PHPML\Graphics\IntPosition as Position;

/**
 * Class MouseButtonEvent
 * Instanciée dynamiquement par la classe Event
 *
 * @package PHPML\Event
 */
class MouseButtonEvent extends TriggerEvent
{
    private Position $position;
    private MouseButton $mouseButton;

    /**
     * @return MouseButton|null
     */
    public function getMouseButton(): ?MouseButton
    {
        $this->updateFromCData();
        return $this->mouseButton;
    }

    /**
     * Accesseur à la position de la souris.
     *
     * @return Position
     */
    public function getPosition(): Position
    {
        $this->updateFromCData();
        return $this->position;
    }

    /**
     * Retourne le nom de la variable du type d'événément en C.
     */
    protected function getEventTypeVarName() : string
    {
        return 'mouseButton';
    }

    protected function updateFromCData(): void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de MouseButton doit être chargé pour mettre à jour et pouvoir accéder aux donnée de la classe MouseButton.");
        }
        $this->mouseButton = new MouseButton($this->cdata->button);
        $this->position->setXPos($this->cdata->x);
        $this->position->setYPos($this->cdata->y);
    }

    /**
     * @inheritDoc
     */
    public function toCData(): CData
    {
        parent::toCData();
        $this->position = new Position(
            $this->cdata->x,
            $this->cdata->y
        );
        return $this->cdata;
    }
}
