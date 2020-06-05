<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Graphics\Event;
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
        if ($event->getType()->getValue() == \PHPML\Enum\EventType::MOUSE_MOVED) {
            var_dump($event->getActualEvent());
        }
    },
    function () use ($window) {
        $window->draw(
            new CircleShape(50)
        );
    }
);