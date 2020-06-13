<?php

namespace PHPML\Graphics;

use PHPML\Enum\Color;
use PHPML\Enum\EventType;
use PHPML\Graphics\Drawable\DrawableInterface;
use PHPML\Library\GraphicsLibLoader as Lib;

/**
 * Classe de fenêtre étendu, possède des méthodes qui facilite la gestion d'événement, le dessin ou le lancement de la fenêtre.
 *
 * @package PHPML\Graphics
 */
class DrawingWindow extends Window
{

    /**
     * @var DrawingList Liste de dessin
     */
    private DrawingList $drawingList;

    /**
     * DrawingWindow constructor.
     *
     * @param VideoMode $mode
     * @param string $title
     * @param array|null $options
     * @param Color $backgroundColor
     */
    public function __construct(
        VideoMode $mode,
        string $title = "PHPML Basic Window",
        array $options = null,
        Color $backgroundColor = null
    ) {
        parent::__construct($mode, $title, $options, $backgroundColor);
        $this->drawingList = new DrawingList();
    }

    public function __destruct()
    {
        if ($this->isCDataLoad()) {
            Lib::getGraphicsLib()->sfRenderWindow_destroy($this->cdata);
            unset($this->cdata);
        }
    }

    /**
     * Lance la boucle principale de la fenêtre et l'ouvre dans le même temps.
     *
     * @param Event $event l'instance d'événement
     * @param callable $eventProcessing fonction de gestion d'événement
     * @param callable $drawing fonction de dessins
     */
    public function run(Event $event, callable $eventProcessing = null, callable $drawing = null)
    {
        $this->cdata ??= $this->toCData();

        //Début de la boucle
        while ($this->isOpen()) {
            // Gestion des événements
            $this->handleEvent($event, $eventProcessing);

            // Nettoyage de l'écran de la fenêtre et affichage
            $this->clear($this->getBackgroundColor());

            // lancement des dessins s'il y en a
            if ($drawing != null) {
                $drawing();
            }
            $this->update();
        }
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
    public function addToDrawingList(string $key, DrawableInterface $object, bool $toDraw = true): void
    {
        $this->drawingList->addObjectToList($key, $object, $toDraw);
    }

    /**
     * Vide la liste de dessin actuelle
     */
    public function setEmptyDrawingList(): void
    {
        $this->drawingList = new DrawingList();
    }

    /**
     * Gestion des événements
     *
     * @param Event $event
     * @param callable $eventProcessing un fonction qui gère les événement dans des blocs conditionnels
     */
    public function handleEvent(Event $event, callable $eventProcessing = null) : void
    {
        while ($this->pollEvent($event->toCData())) {
            // Ferme la fenêtre si l'événement 'close' est enregistrer
            if ($event->getType()->getValue() == EventType::CLOSED) {
                $this->close();
            }

            //Appelle la fonction de gestion d'événement
            if ($eventProcessing != null) {
                $eventProcessing();
            }
        }
    }

    public function update()
    {
        foreach ($this->drawingList->getObjectList() as $drawing) {
            if ($drawing[DrawingList::TO_DRAW]) {
                $drawing[DrawingList::OBJECT_KEY]->draw();
            }
        }
        $this->display();
    }
}
