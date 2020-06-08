<?php


namespace PHPML\Library;

use FFI;
use FFI\Exception;
use InvalidArgumentException;
use PHPML\AbstractFFI\AbstractFFI;
use PHPML\Exception\FFILoadingException;

abstract class LibLoader extends AbstractFFI
{
    const GRAPHICS_SCOPE = 'GRAPHICS';
    const WINDOW_SCOPE = 'WINDOW';

    /**
     * Vérifie si une bibliothèque est chargé et la retourne, si ce n'est pas le cas la méthode initie le chargement de la bibliothèque
     * déjà préchargé par PHP dans le scope GRAPHICS.
     *
     * @throws FFILoadingException si la bibliothèque n'a pas pu être chargé.
     */
    public static function getGraphicsLib() : ?FFI
    {
        return self::getLibWithScope(self::GRAPHICS_SCOPE);
    }

    /**
     * Vérifie si une bibliothèque est chargé et la retourne, si ce n'est pas le cas la méthode initie le chargement de la bibliothèque
     * déjà préchargé par PHP dans le scope WINDOW.
     *
     * @throws FFILoadingException si la bibliothèque n'a pas pu être chargé
     */
    public static function getWindowLib() : ?FFI
    {
        return self::getLibWithScope(self::WINDOW_SCOPE);
    }

    /**
     * Vérifie si une bibliothèque est chargé et la retourne, si ce n'est pas le cas la méthode initie le chargement de la bibliothèque
     * de l'espace donnée en paramètre.
     *
     * @param string $scope l'espace de définition de la bibliothèque à chargé
     * @return FFI|null
     * @throws InvalidArgumentException si l'espace donné en paramètre n'est pas valide
     * @throws FFILoadingException si la bibliothèque n'a pas pu être chargé
     */
    public static function getLibWithScope(string $scope) : ?FFI
    {
        if ($scope != self::GRAPHICS_SCOPE && $scope != self::WINDOW_SCOPE) {
            throw new InvalidArgumentException("L'espace de définition donnée n'existe pas parmi ceux pris en charge.");
        }
        if (!static::isLibLoad()) {
            try {
                static::initLib('preload', $scope);
            } catch (Exception $exception) {
                throw new FFILoadingException($exception->getMessage());
            }
        }
        return static::$lib;
    }
}
