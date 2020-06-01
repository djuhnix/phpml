<?php


namespace PHPML\Enum;

use MyCLabs\Enum\Enum;

class WindowStyle extends Enum
{
    /**
     * No border / title bar (this flag and all others are mutually exclusive)
     */
    const NONE          = 'sfNone';
    /**
     * Title bar + fixed border
     */
    const TITLE_BAR     = 'sfTitlebar';
    /**
     * Titlebar + resizable border + maximize button
     */
    const RESIZE        = 'sfResize';
    /**
     * Titlebar + close button
     */
    const CLOSE         = 'sfClose';
    /**
     * Fullscreen mode (this flag and all others are mutually exclusive)
     */
    const FULL_SCREEN   = 'sfFullscreen';
    /**
     * Default style
     */
    const DEFAULT       = 'sfDefaultStyle';
}
