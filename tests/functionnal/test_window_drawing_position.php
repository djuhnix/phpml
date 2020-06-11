<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Graphics\Event;
use PHPML\Graphics\Shape\CircleShape;
use PHPML\Graphics\Shape\Position;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\Window;

$window = new Window(
    new VideoMode(800, 600)
);

$window->run(
    new Event(),
    null,
    function () use ($window) {
        $circle = new CircleShape(50);
        $circle->setPosition(
            new Position(400, 300)
        );
        $window->draw(
            $circle
        );
    }
);
