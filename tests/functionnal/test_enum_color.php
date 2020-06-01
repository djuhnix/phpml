<?php
require_once '../../vendor/autoload.php';

use PHPML\Enum\Color;


$color = (new Color(Color::DYNAMIC)) // équivaut à Color::DYNAMIC()
    ->fromRGB(12, 12, 13);

var_dump($color);
