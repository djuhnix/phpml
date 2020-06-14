<?php


namespace PHPML\Graphics\Input;

use PHPML\Enum\MouseButton;
use PHPML\Graphics\Window;
use PHPML\Library\GraphicsLibLoader;
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
        return Lib::getWindowLib()->sfMouse_isButtonPressed($button->getValue());
    }

    /**
     * Donne la position actuelle de la souris, relative à une fenêtre
     * ou à l'écran d'ordinateur si le paramètre est laissé null.
     *
     * @param Window $window
     * @return array couple contenant les coordonnées [x, y] de la souris
     */
    public static function getPosition(Window $window = null): array
    {
        $positionCData = GraphicsLibLoader::getGraphicsLib()->sfMouse_getPositionRenderWindow($window->getCData());
        return [$positionCData->x, $positionCData->y];
    }
}
