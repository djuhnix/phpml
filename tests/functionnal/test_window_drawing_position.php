<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Enum\Color;
use PHPML\Graphics\Drawable\Shape\CircleShape;
use PHPML\Graphics\Event;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\DrawingWindow;

$window = new DrawingWindow(
    new VideoMode(800, 600)
);

$window->run(
    new Event(),
    null,
    function () use ($window) {
        $circle = new CircleShape(50);
        $circle->setFillColor(new Color(Color::RED));
        $circle->setPosition([400, 300]);
        $window->draw(
            $circle
        );
    }
);
