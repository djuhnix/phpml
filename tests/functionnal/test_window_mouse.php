<?php
require_once __DIR__ . '/../../vendor/autoload.php';

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
$event = new Event();
$window->run(
    $event,
    function () use ($event, $window) {
        if ($event->getType()->getValue() == EventType::MOUSE_BUTTON_PRESSED) {
            echo $event->getActualEvent() == null ? "null event" :  "CLICK";
        }
    },
    function () use ($event, $window) {
        $window->draw(
            new CircleShape(50)
        );
        if (Mouse::isButtonPressed(MouseButton::MOUSE_LEFT())) {
            $circle = new CircleShape(50);
            $circle->setFillColor(
                (new Color(Color::DYNAMIC))
                    ->fromRGB(150, 100, 200)
            );
            $window->draw(
                $circle
            );
        }
    }
);
