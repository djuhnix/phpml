<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Graphics\Shape\CircleShape;
use PHPML\Graphics\Size;
use PHPML\Graphics\Window;

$window = new Window(
    new Size(800, 600)
);

$window->run(
    null,
    function () use ($window) {
        $window->draw(
            new CircleShape(50)
        );
    }
);

var_dump($window);
