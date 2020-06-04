<?php


namespace PHPML\Enum;

use FFI;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CDataEnum as Enum;
use PHPML\Graphics\GraphicsLibLoader as Lib;

class EventType extends Enum
{
    /**
     * The window requested to be closed (no data)
     */
    const SF_CLOSED        = 'sfEvtClosed';
    /**
     * The window was resized (data in event.size)
     */
    const SF_RESIZED       = 'sfEvtResized';
    /**
     * The window lost the focus (no data)
     */
    const SF_LOST_FOCUS    = 'sfEvtLostFocus';
    /**
     * The window gained the focus (no data)
     */
    const SF_GAINED_FOCUS  = 'sfEvtGainedFocus';

    // Énumération utilisé pour le chargement dynamique

    const CLOSED                    = 0;                 ///< The window requested to be closed (no data)
    const RESIZED                   = 1;                ///< The window was resized (data in event.size)
    const LOST_FOCUS                = 2;              ///< The window lost the focus (no data)
    const GAINED_FOCUS              = 3;            ///< The window gained the focus (no data)
    const TEXT_ENTERED              = 4;            ///< A character was entered (data in event.text)
    const KEY_PRESSED               = 5;             ///< A key was pressed (data in event.key)
    const KEY_RELEASED              = 6;            ///< A key was released (data in event.key)
    const MOUSE_WHEEL_MOVED         = 7;        ///< The mouse wheel was scrolled (data in event.mouseWheel) (deprecated)
    const MOUSE_WHEEL_SCROLLED      = 8;     ///< The mouse wheel was scrolled (data in event.mouseWheelScroll)
    const MOUSE_BUTTON_PRESSED      = 9;     ///< A mouse button was pressed (data in event.mouseButton)
    const MOUSE_BUTTON_RELEASED     = 10;    ///< A mouse button was released (data in event.mouseButton)
    const MOUSE_MOVED               = 11;             ///< The mouse cursor moved (data in event.mouseMove)
    const MOUSE_ENTERED             = 12;           ///< The mouse cursor entered the area of the window (no data)
    const MOUSE_LEFT                = 13;              ///< The mouse cursor left the area of the window (no data)
    const JOYSTICK_BUTTON_PRESSED   = 14;  ///< A joystick button was pressed (data in event.joystickButton)
    const JOYSTICK_BUTTON_RELEASED  = 15; ///< A joystick button was released (data in event.joystickButton)
    const JOYSTICK_MOVED            = 16;          ///< The joystick moved along an axis (data in event.joystickMove)
    const JOYSTICK_CONNECTED        = 17;      ///< A joystick was connected (data in event.joystickConnect)
    const JOYSTICK_DISCONNECTED     = 18;   ///< A joystick was disconnected (data in event.joystickConnect)
    const TOUCH_BEGAN               = 19;             ///< A touch event began (data in event.touch)
    const TOUCH_MOVED               = 20;             ///< A touch moved (data in event.touch)
    const TOUCH_ENDED               = 21;             ///< A touch event ended (data in event.touch)
    const SENSOR_CHANGED            = 22;          ///< A sensor value changed (data in event.sensor)

    const COUNT                     = 23;
}
