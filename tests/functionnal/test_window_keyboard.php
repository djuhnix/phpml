<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Enum\Color;
use PHPML\Enum\KeyCode;
use PHPML\Graphics\Drawable\Shape\CircleShape;
use PHPML\Graphics\Event;
use PHPML\Graphics\Input\Keyboard;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\ExtendedWindow;

$window = new ExtendedWindow(
    new VideoMode(800, 600)
);
$event = new Event();
$window->run(
    $event,
    function () use ($event, $window) {
        if ($event->getType()->getValue() == \PHPML\Enum\EventType::KEY_PRESSED) {
            echo $event->getActualEvent() == null ? "null event" :  "KEY";
        }
    },
    function () use ($event, $window) {
        $circle = new CircleShape(50);

        $window->draw($circle);

        if (Keyboard::isKeyPressed(KeyCode::KEY_ENTER())) {
            $circle->setFillColor(
                (new Color(Color::DYNAMIC))
                    ->fromRGB(150, 100, 200)
            );
            $window->draw($circle);
        }
        if (Keyboard::isKeyPressed(KeyCode::KEY_RIGHT())) {
            $circle->move([200, 200]);
            $circle->setFillColor(
                (new Color(Color::DYNAMIC))
                    ->fromRGB(150, 200, 200)
            );
            $window->draw($circle);
        }
    }
);
