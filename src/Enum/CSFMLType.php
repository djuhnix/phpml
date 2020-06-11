<?php


namespace PHPML\Enum;

use MyCLabs\Enum\Enum;

class CSFMLType extends Enum
{
    // Scalar type
    const UINT_8                = 'sfUint8';
    const UINT_32               = 'sfUint32';
    const BOOL                  = 'sfBool';

    // Array
    const VECTOR_2F            = 'sfVector2f';

    // Graphics
    const RENDER_WINDOW         = 'sfRenderWindow';
    const VIDEO_MODE            = 'sfVideoMode';
    const COLOR                 = 'sfColor';

    // Event
    const EVENT                 = 'sfEvent';
    const MOUSE_BUTTON_EVENT    = 'sfMouseButtonEvent';
}
