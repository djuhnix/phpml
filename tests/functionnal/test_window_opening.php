<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Graphics\Event;
use PHPML\Graphics\VideoMode;
use PHPML\Graphics\ExtendedWindow;


$window = new ExtendedWindow(
    new VideoMode(800, 600)
);

$window->run(new Event());