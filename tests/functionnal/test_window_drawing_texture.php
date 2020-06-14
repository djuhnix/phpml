<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Enum\Color;
use PHPML\Graphics\Drawable\Shape\CircleShape;
use PHPML\Graphics\Drawable\Shape\RectangleShape;
use PHPML\Graphics\Drawable\Sprite\Sprite;
use PHPML\Graphics\Event;
use PHPML\Graphics\Texture;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\ExtendedWindow;

$window = new ExtendedWindow(
    new VideoMode(800, 600)
);
$texture = (new Texture(100, 100))
    ->loadFromFile(__DIR__ . '/../../assets/images/iutrcc.jpeg');
$window->run(
    new Event(),
    null,
    function () use ($texture, $window) {
        $rectangle = new RectangleShape([225, 225], [150, 250], null, $texture);
        $window->draw($rectangle);
        $window->draw(
            new Sprite(
                new Color(Color::GREEN),
                [10, 20],
                $texture
            )
        );
    }
);
