<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Enum\Color;
use PHPML\Graphics\Drawable\Shape\CircleShape;
use PHPML\Graphics\Event;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\ExtendedWindow;

$window = new ExtendedWindow(
    new VideoMode(800, 600)
);

$circle = new CircleShape(50);
$circle->setFillColor(new Color(Color::RED));
$window->addToDrawingList('circle', $circle);

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
        // car il y est attaché
    }
);
