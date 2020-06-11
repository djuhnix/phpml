<?php


namespace PHPML\Enum;

use MyCLabs\Enum\Enum;

class CSFMLType extends Enum
{
    const RENDER_WINDOW         = 'sfRenderWindow';
    const VIDEO_MODE            = 'sfVideoMode';
    const COLOR                 = 'sfColor';

    // Event
    const EVENT                 = 'sfEvent';
    const MOUSE_BUTTON_EVENT    = 'sfMouseButtonEvent';
}
