<?php


namespace PHPML\Graphics\Input;

use PHPML\Enum\KeyCode;
use PHPML\Library\WindowLibLoader as Lib;

class Keyboard
{
    /**
     * @param KeyCode $code
     * @return bool
     */
    public static function isKeyPressed(KeyCode $code): bool
    {
        if (is_string($code->getValue())) {
            throw new \InvalidArgumentException("La valeur du code de la touche de clavier ne doit pas être de type SF_*.");
        }
        $codeCData = KeyCode::toCDataValue(
            KeyCode::CODE_TYPE[$code->getValue()]
        );
        return Lib::getWindowLib()->sfKeyboard_isKeyPressed(
            $codeCData
        );
    }
}
