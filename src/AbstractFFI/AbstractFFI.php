<?php


namespace PHPML\AbstractFFI;

use FFI;
use InvalidArgumentException;
use PHPML\Exception\FFILoadingException;

abstract class AbstractFFI
{
    /**
     * Tableau de bibliothèque FFI
     *
     * @var FFI[]|null
     */
    protected ?array $lib = null;

    /**
     * Instancie un objet FFI contenant une bibliothèque C selon la méthode de chargement, et l'ajoute à la liste de bibliothèque.
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
     * @param string $key clé d'accès à la bibliothèque ajouté.
     * @return void
     */
    protected function addLib(string $method, string $attr, string $key) : void
    {
        $this->lib = [];
        switch ($method) {
            case 'inline':
                if (is_array($attr)) {
                    $this->lib = [
                        $key => FFI::cdef($attr[0], $attr[1])
                    ];
                }
                $this->lib = [
                    $key => FFI::cdef(is_string($attr) ? $attr : '')
                ];
                break;
            case 'preload':
                $this->lib = [
                    $key => FFI::scope(is_string($attr) ? $attr : '')
                ];
                break;
            case 'file':
                $this->lib = [
                    $key => FFI::load(is_string($attr) ? $attr : '')
                ];
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
    }

    /**
     * Vérifie si la bibliothèque est bien chargé.
     *
     * @return bool selon que la bibliothèque est chargé ou non
     */
    public function isLibTableInit(): bool
    {
        return $this->lib != null;
    }

    public function isLibLoad(string $key): bool
    {
        $ret = false;
        if ($this->isLibTableInit() && array_key_exists($key, $this->lib)) {
            $ret = true;
        }
        return $ret;
    }


    /**
     * Accesseur à une librairie chargé.
     *
     * @param string $key clé de la bibliothèque à retourné
     * @return FFI|null
     */
    public function getLib(string $key): ?FFI
    {
        if (!$this->isLibLoad($key)) {
            throw new FFILoadingException("La bibliothèque identifiée par $key n'a pas été chargé");
        }
        return $this->lib[$key];
    }

    /**
     * Retourne le tableau de bibliothèque.
     *
     * @return array|FFI[]|null
     */
    public function getAllLib() : ?array
    {
        return $this->lib;
    }
}
