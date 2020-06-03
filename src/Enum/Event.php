<?php


namespace PHPML\Enum;

use FFI;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CDataEnum as Enum;
use PHPML\Graphics\GraphicsLibLoader as Lib;

class Event extends Enum
{
    use MyCData;
    /**
     * The window requested to be closed (no data)
     */
    const CLOSED        = 'sfEvtClosed';
    /**
     * The window was resized (data in event.size)
     */
    const RESIZED       = 'sfEvtResized';
    /**
     * The window lost the focus (no data)
     */
    const LOST_FOCUS    = 'sfEvtLostFocus';
    /**
     * The window gained the focus (no data)
     */
    const GAINED_FOCUS  = 'sfEvtGainedFocus';

    const LIB_MANAGED = 'Gérer par la bibliothèque C';

    /**
     * @throws \InvalidArgumentException si l'événement n'a pas pour valeur LIB_MANAGED
     */
    public function toCData(): FFI\CData
    {
        if ($this->value != static::LIB_MANAGED) {
            throw new \InvalidArgumentException("L'événement créer doit avoir la valeur 'LIB_MANAGE' pour être chargeable dans la bibliothèque.");
        }

        $this->ctype = Lib::getGraphicsLib()->type(CSFMLType::EVENT);
        $this->cdata ??= Lib::getGraphicsLib()->new($this->ctype, false);
        return $this->cdata;
    }
}
