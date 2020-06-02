<?php


namespace PHPML;

use FFI;
use InvalidArgumentException;

trait AbstractFFI
{
    protected ?FFI $lib = null;
    protected ?FFI\CData $cdata = null;
    protected ?FFI\CType $ctype = null;

    private string $method = '';
    private string $header = '';
    private string $scope = '';

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
     * @throws InvalidArgumentException quand la une méthode non reconnu a été donné en paramètre.
     */
    public function initLib(string $method, string $attr)
    {
        switch ($method) {
            case 'inline':
                if (is_array($attr)) {
                    $this->lib ??= FFI::cdef($attr[0], $attr[1]);
                }
                $this->lib ??= FFI::cdef(is_string($attr) ? $attr : '');
                $this->method = $method;
                break;
            case 'preload':
                $this->lib ??= FFI::scope(is_string($attr) ? $attr : '');
                $this->method = $method;
                $this->scope = $attr;
                break;
            case 'file':
                $this->lib ??= FFI::load(is_string($attr) ? $attr : '');
                $this->method = $method;
                $this->header = $attr;
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
    public function isLibLoad(): bool
    {
        return $this->lib != null;
    }

    /**
     * Vérifie si la donnée C a déjà été chargée.
     *
     * @return bool selon que la donnée a été chargé ou non
     */
    public function isCDataLoad() : bool
    {
        return$this->cdata != null;
    }

    /**
     * Accesseur à la donnée C.
     *
     * @return FFI\CData|null
     */
    public function getCData(): ?FFI\CData
    {
        return $this->cdata;
    }

    /**
     * Accesseur à la méthode de chargement.
     * Accessible seulement si la bibliothèque est déjà chargé.
     *
     * @return string|null ?string
     */
    public function getLibMethod(): ?string
    {
        $ret = null;
        if (self::isLibLoad()) {
            $ret = $this->method;
        }
        return $ret;
    }

    /**
     * Accesseur au chemin du fichier preloading chargé quand la méthode est file.
     * Accessible seulement si la bibliothèque est déjà chargé.
     *
     * @return string|null ?string
     */
    public function getLibHeader(): ?string
    {
        $ret = null;
        if (self::isLibLoad() && $this->method == 'file') {
            $ret = $this->header;
        }
        return $ret;
    }

    /**
     * Accesseur au 'scope' de définition de la bibliothèque défini en préchargement PHP.
     * Accessible seulement si la bibliothèque est déjà chargé.
     *
     * @return string|null ?string
     */
    public function getLibScope(): ?string
    {
        $ret = null;
        if (self::isLibLoad() && $this->method == 'preload') {
            $ret = $this->scope;
        }
        return $ret;
    }

    /**
     * Convertie l'instance actuelle en donnée C utilisable avec la bibliothèque.
     *
     * @return FFI\CData
     */
    abstract public function toCData() : FFI\CData;
}
