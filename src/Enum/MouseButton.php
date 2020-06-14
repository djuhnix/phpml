<?php

namespace PHPML\Enum;

class MouseButton extends CDataEnum
{
    const MOUSE_LEFT            = 0; ///< The left mouse button
    const MOUSE_RIGHT           = 1; ///< The right mouse button
    const MOUSE_MIDDLE          = 2; ///< The middle (wheel) mouse button
    const MOUSE_XBUTTON1        = 3; ///< The first extra mouse button
    const MOUSE_XBUTTON2        = 4; ///< The second extra mouse button

    const MOUSE_BUTTON_COUNT    = 5; ///< Keep last -- the total number of mouse buttons
}
