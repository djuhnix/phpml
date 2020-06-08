<?php


namespace PHPML\Library;

use FFI;
use PHPML\Exception\FFILoadingException;

class GraphicsLibLoader extends LibLoader
{
    /**
     * Vérifie si une bibliothèque est chargé et la retourne, si ce n'est pas le cas la méthode initie le chargement de la bibliothèque
     * déjà préchargé par PHP dans le scope GRAPHICS.
     *
     * @throws FFILoadingException si la bibliothèque n'a pas pu être chargé.
     */
    public static function getGraphicsLib() : ?FFI
    {
        return static::getLibWithScope(static::GRAPHICS_SCOPE)
            ->getLib(static::GRAPHICS_SCOPE);
    }
}
