<?php


namespace PHPML\Graphics\Input;

use FFI\CData;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\MouseButton;
use PHPML\Graphics\GraphicsLibLoader as Lib;

class Mouse
{
    /**
     * Vérifie si un bouton de la souris est cliqué
     *
     * @param MouseButton $button le bouton à vérifier
     * @return bool si le bouton est cliqué ou pas.
     */
    public static function isButtonPressed(MouseButton $button) : bool
    {
        if ($button->getValue() == MouseButton::MOUSE_BUTTON_COUNT
            || is_string($button->getValue())) {
            throw new \InvalidArgumentException("La valeur du bouton ne doit pas être de type SF_* ni MOUSE_BUTTON_COUNT");
        }
        return Lib::getGraphicsLib()->sfMouse_isButtonPressed(
            $button->getValue()
        );
    }
}
