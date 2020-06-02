<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPML\Graphics\Size;
use PHPML\Graphics\Window;


$window = new Window(
    new Size(800, 600)
);

$window->run();
var_dump($window->getSize()->getCData());
