<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Graphics\Event;
use PHPML\Graphics\Shape\CircleShape;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\Window;

$window = new Window(
    new VideoMode(800, 600)
);

$window->run(
    new Event(),
    null,
    function () use ($window) {
        $window->draw(
            new CircleShape(50)
        );
    }
);