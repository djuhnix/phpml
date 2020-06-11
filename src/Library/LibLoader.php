<?php


namespace PHPML\Library;

use FFI\Exception;
use InvalidArgumentException;
use PHPML\AbstractFFI\AbstractFFI;
use PHPML\Exception\FFILoadingException;

class LibLoader extends AbstractFFI
{
    const GRAPHICS_SCOPE = 'GRAPHICS';
    const WINDOW_SCOPE = 'WINDOW';

    protected static ?self $instance = null;

    /**
     * LibLoader constructeur privé pour éviter l'instanciation externe.
     *
     * @param string $method méthode d'initialisation de la bibliothèque
     * @param string $attr attribut équivalent à la méthode d'initialisation
     * @param string $key clé d'accès à la bibliothèque ajouté
     * @see AbstractFFI::addLib()
     */
    private function __construct(string $method, string $attr, string $key)
    {
        if (!$this->isLibTableInit()) {
            try {
                $this->addLib($method, $attr, $key);
            } catch (Exception $exception) {
                throw new FFILoadingException($exception->getMessage());
            }
        }
    }

    /**
     * Vérifie si une bibliothèque est chargé et la retourne, si ce n'est pas le cas la méthode initie le chargement de la bibliothèque
     * de l'espace donnée en paramètre.
     *
     * @param string $scope l'espace de définition de la bibliothèque à chargé
     * @return LibLoader
     * @throws InvalidArgumentException si l'espace donné en paramètre n'est pas valide
     * @throws FFILoadingException si la bibliothèque n'a pas pu être chargé
     */
    public static function getLibWithScope(string $scope) : LibLoader
    {
        if ($scope != self::GRAPHICS_SCOPE && $scope != self::WINDOW_SCOPE) {
            throw new InvalidArgumentException("L'espace de définition donnée n'existe pas parmi ceux pris en charge.");
        }
        if (static::$instance == null) {
            static::$instance = new static('preload', $scope, $scope);
        } else {
            if (!static::$instance->isLibLoad($scope)) {
                static::$instance->addLib('preload', $scope, $scope);
            }
        }
        return static::$instance;
    }
}
