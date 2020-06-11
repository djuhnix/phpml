<?php


namespace PHPML\Event;

use FFI\CData;
use PHPML\Enum\KeyCode;
use PHPML\Graphics\Event;

class KeyEvent extends TriggerEvent
{

    private KeyCode $code;
    private bool $alt;
    private bool $control;
    private bool $shift;
    private bool $system;

    /**
     * @return bool
     */
    public function isAlt(): bool
    {
        return $this->alt;
    }

    /**
     * @return bool
     */
    public function isControl(): bool
    {
        return $this->control;
    }

    /**
     * @return bool
     */
    public function isShift(): bool
    {
        return $this->shift;
    }

    /**
     * @return bool
     */
    public function isSystem(): bool
    {
        return $this->system;
    }

    /**
     * @inheritDoc
     */
    public function toCData(): CData
    {
        // TODO: Implement toCData() method.
    }

    /**
     * @inheritDoc
     */
    protected function getEventTypeVarName(): string
    {
        return 'key';
    }
}
