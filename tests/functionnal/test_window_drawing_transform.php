<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Enum\Color;
use PHPML\Graphics\Drawable\Shape\CircleShape;
use PHPML\Graphics\Drawable\Shape\RectangleShape;
use PHPML\Graphics\Event;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\ExtendedWindow;

$window = new ExtendedWindow(
    new VideoMode(800, 600)
);

$circle = new CircleShape(50, [0, 0], new Color(Color::RED));

$rectangle = new RectangleShape([100, 100], [150, 150], new Color(Color::RED));
$rectangle->setOrigin([50, 50]); // redéfini l'origine par défaut du rectangle pour améliorer la rotation

$window->addToDrawingList('circle', $circle);
$window->addToDrawingList('rectangle', $rectangle);

$window->run(
    new Event(),
    null,
    function () use ($window) {
        $window
            ->getDrawingList()
            ->getObject('circle')
            ->move([1, 1]);
        // cette fonction est appelée dans une boucle while dans la fonction run
        // le cercle aura donc une animation de déplacement en diagonale sur la fenêtre
        // car il y est attaché et est mis à jour à chaque fin de cycle

        $window
            ->getDrawingList()
            ->getObject('rectangle')
            ->rotate(0.5);
        // de la même manière le rectangle (qui est un carré) sera en continuelle rotation
    }
);
