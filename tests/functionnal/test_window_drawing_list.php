<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Enum\Color;
use PHPML\Graphics\Drawable\Shape\CircleShape;
use PHPML\Graphics\Drawable\Shape\RectangleShape;
use PHPML\Graphics\Event;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\DrawingWindow;

$window = new DrawingWindow(
    new VideoMode(800, 600)
);

$window->addToDrawingList(
    'rectangle',
    new RectangleShape(
        [400, 200],
        [100, 200],
        new Color(Color::BLUE) // définition de la couleur de fond en bleue
    )
);

$red = new Color(Color::RED);
$circle = new CircleShape(
    50,
    [10, 20],
    $red
);
$window->run(
    new Event(),
    null,
    function () use ($red, $circle, $window) {
        $window->draw($circle);

        $window
            ->getDrawingList()
            ->getObject('rectangle')
            ->setFillColor($red) // Le rectangle affiché sera rouge au lieu d'être bleue comme défini plus
    ;
    }
);
