<?php


namespace PHPML\AbstractFFI;

use FFI;
use InvalidArgumentException;

abstract class AbstractFFI
{
    protected static ?FFI $lib = null;

    /**
     * Instancie un objet FFI contenant une bibliothèque C selon la méthode de chargement.
     * Si la bibliothèque est correctement chargé elle est accessible via l'attribut de classe $lib
     *
     * @param string $method la méthode de chargement de la bibliothèque C.
     *                       n'accepte que trois valeur :
     *                          - inline : une séquence de déclaration en C doit être fourni au second paramètre.
     *                              Un tableau peut aussi être passé au second paramètre.
     *                              La première valeur étant la séquence de déclaration en C,
     *                              et la deuxième le fichier de la bibliothèque à charger.
     *                          - preload : charge dans l'objet FFI une bibliothèque déjà préchargé par PHP.
     *                              Dans ce cas le nom du 'scope' doit être passer en au second paramètre.
     *                          - file : instancie l'objet FFI selon les déclarations C contenu dans un fichier preloading (.h)
     *                              Le chemin vers le fichier doit être passer au second paramètre.
     *
     * @param string $attr dépend du premier paramètre.
     *                     Elle peut recevoir une chaine de caractère représentant une séquence de déclaration en C ou un chemin vers le fichier h.
     *                     Un tableau de taille 2 peut également être passé si la méthode est 'inline'.
     *                     Si un type non attendu, un mauvais chemin ou une valeur contraire à la méthode définie est passé, un comportement non attendu pourrait survenir et la bibliothèque ne serait pas chargé.
     *
     * @return FFI
     * @throws InvalidArgumentException quand la une méthode non reconnu a été donné en paramètre.
     */
    protected static function initLib(string $method, string $attr) : FFI
    {
        switch ($method) {
            case 'inline':
                if (is_array($attr)) {
                    static::$lib ??= FFI::cdef($attr[0], $attr[1]);
                }
                static::$lib ??= FFI::cdef(is_string($attr) ? $attr : '');
                break;
            case 'preload':
                static::$lib ??= FFI::scope(is_string($attr) ? $attr : '');
                break;
            case 'file':
                static::$lib ??= FFI::load(is_string($attr) ? $attr : '');
                break;
            default:
                throw new InvalidArgumentException(
                    <<<MSG
Le paramètre 'method' a été mal renseigné.
    Attendu : 'inline', 'preload' ou 'file'.
    Reçu : $method
MSG
                );
                break;
        }
        return static::$lib;
    }

    /**
     * Vérifie si la bibliothèque est bien chargé.
     *
     * @return bool selon que la bibliothèque est chargé ou non
     */
    public static function isLibLoad(): bool
    {
        return static::$lib != null;
    }
}
