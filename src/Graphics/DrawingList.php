<?php


namespace PHPML\Graphics;

use PHPML\Graphics\Drawable\DrawableInterface;

class DrawingList
{
    const OBJECT_KEY    = 'object';
    const TO_DRAW       = 'toDraw';

    /**
     * Liste d'objets à dessiner lors du rafraîchissement de la fenêtre
     * La liste est un tableau associatif de la forme :
     * [ $objectKey => [ 'object' => $shape,
     *                   'toDraw' => bool ],
     *   $objectKey => [ 'object' => $shape,
     *                   'toDraw' => bool ],
     *   ...
     * ]
     * @var array
     */
    private array $objectList;

    /**
     * DrawingList constructor.
     */
    public function __construct()
    {
        $this->objectList = [];
    }

    /**
     * Ajoute un objet à dessiner à la liste de dessin, si la clé existe déjà dans la liste l'objet est remplacé.
     * Les objets ajouté seront dessiner lors du rafraîchissement de la fenêtre.
     * Ce comportement peut être changé en spéciant le paramètre toDraw à false.
     *
     * @param DrawableInterface $object
     * @param string $key clé d'accès à l'objet ajouté
     * @param bool $toDraw décide si l'objet doit être dessiné en fin de cycle de rafraîchissement
     */
    public function addObjectToList(string $key, DrawableInterface $object, bool $toDraw = true): void
    {
        $this->objectList[$key] = [
            static::OBJECT_KEY => $object,
            static::TO_DRAW => $toDraw
        ];
    }

    /**
     * Accesseur à la liste complète d'objets à dessiner.
     *
     * @return array la liste d'objets au format spécifié
     * @see DrawingList::$objectList
     */
    public function getObjectList(): array
    {
        return $this->objectList;
    }

    /**
     * Accesseur à un objet précis de la liste de dessins
     *
     * @param string $key
     * @return DrawableInterface
     */
    public function getObject(string $key): DrawableInterface
    {
        return $this->objectList[$key][static::OBJECT_KEY];
    }

    /**
     * Accesseur à l'attribut toDraw d'un objet
     * @param string $key
     * @return mixed
     */
    public function isObjectToDraw(string $key)
    {
        return $this->objectList[$key][static::TO_DRAW];
    }

    /**
     * Modifie l'attribut toDraw d'un objets à dessiner définissant s'il doit être déssiner ou pas
     *
     * @param string $key la clé de l'objet
     * @param bool $toDraw la nouvelle valeur de l'attribut
     */
    public function setToDraw(string $key, bool $toDraw): void
    {
        $this->objectList[$key][static::TO_DRAW] = $toDraw;
    }
}
