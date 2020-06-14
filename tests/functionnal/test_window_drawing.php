<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Enum\Color;
use PHPML\Graphics\Drawable\Shape\CircleShape;
use PHPML\Graphics\Drawable\Shape\RectangleShape;
use PHPML\Graphics\Drawable\Text\Text;
use PHPML\Graphics\Event;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\ExtendedWindow;

$window = new ExtendedWindow(
    new VideoMode(800, 600)
);
$red = new Color(Color::RED);
$blue = new Color(Color::BLUE);
$text = new Text("Hello", $red);
$text->setFillColor($blue);
$text->setPosition([50, 50]);
$text->setCharacterSize(50);
$window->run(
    new Event(),
    null,
    function () use ($text, $blue, $red, $window) {
        /*
        $window->draw(
            new RectangleShape(
                [400, 200],
                [100, 200],
                $blue
            )
        );

        $window->draw(
            new CircleShape(
                50,
                [10, 20],
                $red
            )
        );
        */

        $window->draw(
            $text
        );
    }
);
