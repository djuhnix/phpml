<?php


namespace PHPML\Event;

use FFI\CData;
use PHPML\Enum\CSFMLType;
use PHPML\Enum\KeyCode;
use PHPML\Exception\CDataException;
use PHPML\Library\GraphicsLibLoader as Lib;

class KeyEvent extends TriggerEvent
{
    private KeyCode $code;
    private bool $alt;
    private bool $control;
    private bool $shift;
    private bool $system;

    /**
     * @return KeyCode
     */
    public function getCode(): KeyCode
    {
        $this->updateFromCData();
        return $this->code;
    }

    /**
     * @return bool
     */
    public function isAlt(): bool
    {
        $this->updateFromCData();
        return $this->alt;
    }

    /**
     * @return bool
     */
    public function isControl(): bool
    {
        $this->updateFromCData();
        return $this->control;
    }

    /**
     * @return bool
     */
    public function isShift(): bool
    {
        $this->updateFromCData();
        return $this->shift;
    }

    /**
     * @return bool
     */
    public function isSystem(): bool
    {
        $this->updateFromCData();
        return $this->system;
    }

    protected function updateFromCData() :void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de KeyEvent doit être chargé pour mettre à jour t pouvoir accéder aux donnée de la classe KeyEvent.");
        }
        $this->alt = $this->cdata->alt;
        $this->control = $this->cdata->control;
        $this->shift = $this->cdata->shift;
        $this->system = $this->cdata->system;
        $this->code = new KeyCode($this->cdata->code);
    }

    /**
     * @inheritDoc
     */
    protected function getEventTypeVarName(): string
    {
        return 'key';
    }
}
