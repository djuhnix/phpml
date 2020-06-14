<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Enum\EventType;
use PHPML\Graphics\Event;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\ExtendedWindow;
use PHPML\Graphics\Window;

////////////////////////////////
// Méthode avec la classe Window
////////////////////////////////
$window = new Window(
    new VideoMode(400, 400),
    'Test Window Opening'
);
$event = new Event();
//Début de la boucle
while ($window->isOpen()) {
    // Gestion des événements
    while ($window->pollEvent($event->toCData())) {
        // Ferme la fenêtre si l'événement 'close' est enregistrer
        if ($event->getType()->getValue() == EventType::CLOSED) {
            $window->close();
        }
    }
    // Nettoyage de l'écran de la fenêtre et affichage
    $window->clear($window->getBackgroundColor());

    // lancement des dessins s'il y en a
    $window->display();
}

////////////////////////////////
// Avec la classe ExtendedWindow
////////////////////////////////
$window = new ExtendedWindow(
    new VideoMode(800, 600)
);

$window->run(new Event());

/*
 * La fenêtre vont s'ouvrir l'une après l'autre,
 * à cause de la boucle while la deuxième fenêtre ne s'ouvrira pas tant que
 * le première n'est pas fermé
 */
