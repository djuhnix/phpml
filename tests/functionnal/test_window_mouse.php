<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Enum\Color;
use PHPML\Enum\MouseButton;
use PHPML\Graphics\Event;
use PHPML\Graphics\Input\Mouse;
use PHPML\Graphics\Shape\CircleShape;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\Window;

$window = new Window(
    new VideoMode(800, 600)
);
$event = new Event();
$window->run(
    $event,
    function () use ($event, $window) {
        if ($event->getType()->getValue() == \PHPML\Enum\EventType::MOUSE_BUTTON_PRESSED) {
            var_dump($event->getActualEvent() == null ? "null event" :  $event->getActualEvent()->getEventType());
        }
    },
    function () use ($event, $window) {
        $window->draw(
            new CircleShape(50)
        );
        if (Mouse::isButtonPressed(MouseButton::MOUSE_LEFT())) {
            $circle = new CircleShape(50);
            $circle->setFillColor(
                (new Color(Color::BLUE))
            );
            $window->draw(
                $circle
            );
        }
    }
);
