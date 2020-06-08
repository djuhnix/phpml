<?php


namespace PHPML\Library;

use FFI;
use FFI\Exception;
use InvalidArgumentException;
use PHPML\Exception\FFILoadingException;

class WindowLibLoader extends LibLoader
{
    /**
     * Vérifie si une bibliothèque est chargé et la retourne, si ce n'est pas le cas la méthode initie le chargement de la bibliothèque
     * déjà préchargé par PHP dans le scope WINDOW.
     *
     * @throws FFILoadingException si la bibliothèque n'a pas pu être chargé
     */
    public static function getWindowLib() : ?FFI
    {
        return static::getLibWithScope(static::WINDOW_SCOPE)
            ->getLib(static::WINDOW_SCOPE);
    }
}
