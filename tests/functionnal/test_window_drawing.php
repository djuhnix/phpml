<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Graphics\Event;
use PHPML\Graphics\Shape\RectangleShape;
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
            new RectangleShape([400, 200], [100, 200])
        );
        $window->draw(
            new \PHPML\Graphics\Shape\CircleShape(50, [10, 20])
        );
    }
);
