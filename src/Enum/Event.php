<?php


namespace PHPML\Enum;


use FFI;
use PHPML\AbstractFFI;
use PHPML\Exception\FFILoadingException;
use PHPML\Graphics\GraphicsLibLoader;

class Event extends \MyCLabs\Enum\Enum
{
    use GraphicsLibLoader;
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

    public function getLibManagedEvent() : self
    {
        if ($this->value != static::LIB_MANAGED) {
            throw new \InvalidArgumentException("L'événement créer doit avoir la valeur 'LIB_MANAGE' pour être chargeable dans la bibliothèque.");
        }
        $this->checkLibAndLoad();
        $this->ctype = $this->lib->type(CSFMLType::EVENT);
        return $this;
    }

    /**
     * @inheritDoc
     * @throws \InvalidArgumentException si l'événement n'a pas pour valeur LIB_MANAGED
     */
    public function toCData(): FFI\CData
    {
        if (!$this->isLibLoad()) {
            throw new FFILoadingException("Impossible de convertir l'événement en donnée C.");
        }

        $this->cdata ??= $this->lib->new($this->ctype, false);
        return $this->cdata;
    }
}