<?php


require_once __DIR__ . '/../vendor/autoload.php';

use PHPML\Enum\Color;
use PHPML\Enum\EventType;
use PHPML\Enum\MouseButton;
use PHPML\Graphics\Drawable\Shape\CircleShape;
use PHPML\Graphics\Event;
use PHPML\Graphics\Input\Mouse;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\ExtendedWindow;

$window = new ExtendedWindow(
    new VideoMode(800, 600)
);

$dynamicColor = new Color(Color::DYNAMIC);
$circle = new CircleShape(
    50,
    [100, 100],
    $dynamicColor
        ->fromRGB(100, 100, 100)
);
$colorArray = [
    Color::RED,
    Color::GREEN,
    Color::BLUE,
    Color::YELLOW,
    Color::MAGENTA,
    Color::CYAN,
];

$event = new Event();
$window->addToDrawingList('circle', $circle);
$i = 0;
$window->run(
    $event,
    function () use ($circle, &$i, $colorArray, $event, $window) {
        if ($event->getType()->getValue() == EventType::MOUSE_BUTTON_PRESSED) {
            $i++;
            if ($i > 5) {
                $i = 0;
            }
            if ($circle->isMouseInside($window)) {
                $circle->setFillColor( // modification de la couleur du cercle en une couleur aléatoire
                    new Color($colorArray[$i])
                );
            }
        }
    }
);
