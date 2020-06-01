#define FFI_LIB "/usr/lib/x86_64-linux-gnu/libcsfml-graphics.so"
#define FFI_SCOPE "GRAPHICS"

typedef unsigned int sfUint32;
typedef int sfBool;
typedef struct {
    int placebo;
} sfView;
typedef struct
{
    int placebo
} sfRenderWindow;

typedef unsigned char sfUint8;

typedef struct
{
    unsigned int width;        ///< Video mode width, in pixels
    unsigned int height;       ///< Video mode height, in pixels
    unsigned int bitsPerPixel; ///< Video mode pixel depth, in bits per pixels
} sfVideoMode;

////////////////////////////////////////////////////////////
/// \brief Utility class for manpulating RGBA colors
///
////////////////////////////////////////////////////////////
typedef struct
{
    sfUint8 r;
    sfUint8 g;
    sfUint8 b;
    sfUint8 a;
} sfColor;

sfColor sfBlack;       ///< Black predefined color
sfColor sfWhite;       ///< Black predefined color

////////////////////////////////////////////////////////////
/// \brief Enumeration of window creation styles
///
////////////////////////////////////////////////////////////
typedef enum
{
    sfNone         = 0,      ///< No border / title bar (this flag and all others are mutually exclusive)
    sfTitlebar     = 1 << 0, ///< Title bar + fixed border
    sfResize       = 1 << 1, ///< Titlebar + resizable border + maximize button
    sfClose        = 1 << 2, ///< Titlebar + close button
    sfFullscreen   = 1 << 3, ///< Fullscreen mode (this flag and all others are mutually exclusive)
    sfDefaultStyle = sfTitlebar | sfResize | sfClose ///< Default window style
} sfWindowStyle;

////////////////////////////////////////////////////////////
/// \brief Definition of all the event types
///
////////////////////////////////////////////////////////////
typedef enum
{
    sfEvtClosed,                 ///< The window requested to be closed (no data)
    sfEvtResized,                ///< The window was resized (data in event.size)
    sfEvtLostFocus,              ///< The window lost the focus (no data)
    sfEvtGainedFocus,            ///< The window gained the focus (no data)
    sfEvtTextEntered,            ///< A character was entered (data in event.text)
    sfEvtKeyPressed,             ///< A key was pressed (data in event.key)
    sfEvtKeyReleased,            ///< A key was released (data in event.key)
    sfEvtMouseWheelMoved,        ///< The mouse wheel was scrolled (data in event.mouseWheel) (deprecated)
    sfEvtMouseWheelScrolled,     ///< The mouse wheel was scrolled (data in event.mouseWheelScroll)
    sfEvtMouseButtonPressed,     ///< A mouse button was pressed (data in event.mouseButton)
    sfEvtMouseButtonReleased,    ///< A mouse button was released (data in event.mouseButton)
    sfEvtMouseMoved,             ///< The mouse cursor moved (data in event.mouseMove)
    sfEvtMouseEntered,           ///< The mouse cursor entered the area of the window (no data)
    sfEvtMouseLeft,              ///< The mouse cursor left the area of the window (no data)
    sfEvtJoystickButtonPressed,  ///< A joystick button was pressed (data in event.joystickButton)
    sfEvtJoystickButtonReleased, ///< A joystick button was released (data in event.joystickButton)
    sfEvtJoystickMoved,          ///< The joystick moved along an axis (data in event.joystickMove)
    sfEvtJoystickConnected,      ///< A joystick was connected (data in event.joystickConnect)
    sfEvtJoystickDisconnected,   ///< A joystick was disconnected (data in event.joystickConnect)
    sfEvtTouchBegan,             ///< A touch event began (data in event.touch)
    sfEvtTouchMoved,             ///< A touch moved (data in event.touch)
    sfEvtTouchEnded,             ///< A touch event ended (data in event.touch)
    sfEvtSensorChanged,          ///< A sensor value changed (data in event.sensor)

    sfEvtCount,                  ///< Keep last -- the total number of event types
} sfEventType;

////////////////////////////////////////////////////////////
/// \brief sfEvent defines a system event and its parameters
///
////////////////////////////////////////////////////////////
typedef union
{
    sfEventType             type;             ///< Type of the event
    /*
    sfSizeEvent             size;             ///< Size event parameters
    sfKeyEvent              key;              ///< Key event parameters
    sfTextEvent             text;             ///< Text event parameters
    sfMouseMoveEvent        mouseMove;        ///< Mouse move event parameters
    sfMouseButtonEvent      mouseButton;      ///< Mouse button event parameters
    sfMouseWheelEvent       mouseWheel;       ///< Mouse wheel event parameters (deprecated)
    sfMouseWheelScrollEvent mouseWheelScroll; ///< Mouse wheel event parameters
    sfJoystickMoveEvent     joystickMove;     ///< Joystick move event parameters
    sfJoystickButtonEvent   joystickButton;   ///< Joystick button event parameters
    sfJoystickConnectEvent  joystickConnect;  ///< Joystick (dis)connect event parameters
    sfTouchEvent            touch;            ///< Touch events parameters
    sfSensorEvent           sensor;           ///< Sensor event parameters
    */
} sfEvent;

typedef struct
{
    unsigned int depthBits;         ///< Bits of the depth buffer
    unsigned int stencilBits;       ///< Bits of the stencil buffer
    unsigned int antialiasingLevel; ///< Level of antialiasing
    unsigned int majorVersion;      ///< Major number of the context version to create
    unsigned int minorVersion;      ///< Minor number of the context version to create
    sfUint32     attributeFlags;    ///< The attribute flags to create the context with
    sfBool       sRgbCapable;       ///< Whether the context framebuffer is sRGB capable
} sfContextSettings;

///////////////////////
/// FUNCTIONS
//////////////////////

////////////////////////////////////////////////////////////
/// \brief Close a render window (but doesn't destroy the internal data)
///
/// \param renderWindow Render window to close
///
////////////////////////////////////////////////////////////
void sfRenderWindow_close(sfRenderWindow* renderWindow);

////////////////////////////////////////////////////////////
/// \brief Tell whether or not a render window is opened
///
/// \param renderWindow Render window object
///
////////////////////////////////////////////////////////////
sfBool sfRenderWindow_isOpen(const sfRenderWindow* renderWindow);

////////////////////////////////////////////////////////////
/// \brief Construct a new render window
///
/// \param mode     Video mode to use
/// \param title    Title of the window
/// \param style    Window style
/// \param settings Creation settings (pass NULL to use default values)
///
////////////////////////////////////////////////////////////
sfRenderWindow* sfRenderWindow_create(sfVideoMode mode, const char* title, sfUint32 style, const sfContextSettings* settings);

////////////////////////////////////////////////////////////
/// \brief Clear a render window with the given color
///
/// \param renderWindow Render window object
/// \param color        Fill color
///
////////////////////////////////////////////////////////////
void sfRenderWindow_clear(sfRenderWindow* renderWindow, sfColor color);

////////////////////////////////////////////////////////////
/// \brief Display a render window on screen
///
/// \param renderWindow Render window object
///
////////////////////////////////////////////////////////////
void sfRenderWindow_display(sfRenderWindow* renderWindow);


////////////////////////////////////////////////////////////
/// \brief Get the event on top of event queue of a render window, if any, and pop it
///
/// \param renderWindow Render window object
/// \param event        Event to fill, if any
///
/// \return sfTrue if an event was returned, sfFalse if event queue was empty
///
////////////////////////////////////////////////////////////
sfBool sfRenderWindow_pollEvent(sfRenderWindow* renderWindow, sfEvent* event);
