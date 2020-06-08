<?php


namespace PHPML\Graphics\Input;

use PHPML\Enum\MouseButton;
use PHPML\Library\WindowLibLoader as Lib;

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
        switch ($button->getValue()) {
            case MouseButton::MOUSE_LEFT:
                $buttonCData = MouseButton::toCDataValue(MouseButton::SF_MOUSE_LEFT);
                break;
            case MouseButton::MOUSE_RIGHT:
                $buttonCData = MouseButton::toCDataValue(MouseButton::SF_MOUSE_RIGHT);
                break;
            case MouseButton::MOUSE_MIDDLE:
                $buttonCData = MouseButton::toCDataValue(MouseButton::SF_MOUSE_MIDDLE);
                break;
            case MouseButton::MOUSE_XBUTTON1:
                $buttonCData = MouseButton::toCDataValue(MouseButton::SF_MOUSE_XBUTTON1);
                break;
            case MouseButton::MOUSE_XBUTTON2:
                $buttonCData = MouseButton::toCDataValue(MouseButton::SF_MOUSE_XBUTTON2);
                break;
            default:
                $buttonCData = null;
                throw new \InvalidArgumentException("La valeur du bouton ne doit pas être de type SF_* ni MOUSE_BUTTON_COUNT");
                break;
        }

        return Lib::getWindowLib()->sfMouse_isButtonPressed(
            $buttonCData
        );
    }
}
