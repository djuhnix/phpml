<?php


namespace PHPML\Library;

use FFI\Exception;
use PHPML\AbstractFFI\AbstractFFI;
use PHPML\Exception\FFILoadingException;

abstract class GraphicsLibLoader extends AbstractFFI
{

    /**
     * Vérifie si une bibliothèque est chargé, si ce n'est pas le cas la méthode initie le chargement de la bibliothèque
     * déjà préchargé par PHP dans le scope GRAPHICS.
     *
     * @throws FFILoadingException si la bibliothèque n'a pas pu être chargé.
     */
    public static function getGraphicsLib() : ?\FFI
    {
        if (!static::isLibLoad()) {
            try {
                static::initLib('preload', 'GRAPHICS');
            } catch (Exception $exception) {
                throw new FFILoadingException($exception->getMessage());
            }
        }
        return static::$lib;
    }
}
