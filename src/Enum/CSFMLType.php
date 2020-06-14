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
    const VECTOR_2F             = 'sfVector2f';
    const VECTOR_2I             = 'sfVector2i';
    const VECTOR_2U             = 'sfVector2u';

    // Graphics
    const RENDER_WINDOW         = 'sfRenderWindow';
    const VIDEO_MODE            = 'sfVideoMode';

    const COLOR                 = 'sfColor';
    // Event
    const EVENT                 = 'sfEvent';
    const KEY_EVENT             = 'sfKeyEvent';
    const MOUSE_BUTTON_EVENT    = 'sfMouseButtonEvent';

    // Shape
    const RECTANGLE_SHAPE       = 'sfRectangleShape';
    const CIRCLE_SHAPE          = 'sfCircleShape';

    // Text
    const TEXT                  = 'sfText';
    const FONT                  = 'sfFont';
}
