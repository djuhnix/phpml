<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Graphics\Drawable\Shape\CircleShape;
use PHPML\Graphics\Drawable\Shape\RectangleShape;
use PHPML\Graphics\Event;
use PHPML\Graphics\Texture;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\DrawingWindow;

$window = new DrawingWindow(
    new VideoMode(800, 600)
);
$texture = (new Texture(225, 225))
    ->loadFromFile(__DIR__ . '/../../assets/images/iutrcc.jpeg');
$window->run(
    new Event(),
    null,
    function () use ($texture, $window) {
        $rectangle = new RectangleShape([225, 225], [100, 200], null, $texture);
        $window->draw($rectangle);
        $window->draw(
            new CircleShape(50, [10, 20], null, $texture)
        );
    }
);
