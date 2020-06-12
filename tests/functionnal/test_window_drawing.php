<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Graphics\Drawable\Shape\CircleShape;
use PHPML\Graphics\Drawable\Shape\RectangleShape;
use PHPML\Graphics\Event;
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
            new CircleShape(50, [10, 20])
        );
    }
);
