#define FFI_SCOPE "GRAPHICS"
#define FFI_LIB "/usr/lib/x86_64-linux-gnu/libcsfml-graphics.so"

typedef unsigned int sfUint32;
typedef int sfBool;

typedef struct
{
    int placebo_sfView;
} sfView;

typedef struct
{
    int placebo_sfRenderStates;
    //sfBlendMode      blendMode; ///< Blending mode
    //sfTransform      transform; ///< Transform
    //const sfTexture* texture;   ///< Texture
    //const sfShader*  shader;    ///< Shader
} sfRenderStates;

typedef struct
{
    int placebo_sfShape;
} sfShape;

typedef struct {
    int placebo_sfCircleShape;
} sfCircleShape;


typedef struct
{
    int placebo_sfRenderWindow;
} sfRenderWindow;

typedef unsigned char sfUint8;

typedef struct
{
    unsigned int width;        ///< Video mode width, in pixels
    unsigned int height;       ///< Video mode height, in pixels
    unsigned int bitsPerPixel; ///< Video mode pixel depth, in bits per pixels
} sfVideoMode;

/////////////////////
// Color
////////////////////
typedef struct
{
    sfUint8 r;
    sfUint8 g;
    sfUint8 b;
    sfUint8 a;
} sfColor;

sfColor sfBlack;       ///< Black predefined color
sfColor sfWhite;       ///< White predefined color
sfColor sfRed;         ///< Red predefined color
sfColor sfGreen;       ///< Green predefined color
sfColor sfBlue;        ///< Blue predefined color
sfColor sfYellow;      ///< Yellow predefined color
sfColor sfMagenta;     ///< Magenta predefined color
sfColor sfCyan;        ///< Cyan predefined color
sfColor sfTransparent; ///< Transparent (black) predefined color

typedef enum
{
    sfNone         = 0,      ///< No border / title bar (this flag and all others are mutually exclusive)
    sfTitlebar     = 1 << 0, ///< Title bar + fixed border
    sfResize       = 1 << 1, ///< Titlebar + resizable border + maximize button
    sfClose        = 1 << 2, ///< Titlebar + close button
    sfFullscreen   = 1 << 3, ///< Fullscreen mode (this flag and all others are mutually exclusive)
    sfDefaultStyle = sfTitlebar | sfResize | sfClose ///< Default window style
} sfWindowStyle;

//////////////////////
// Mouse Enum
//////////////////////

typedef enum
{
    sfMouseLeft,       ///< The left mouse button
    sfMouseRight,      ///< The right mouse button
    sfMouseMiddle,     ///< The middle (wheel) mouse button
    sfMouseXButton1,   ///< The first extra mouse button
    sfMouseXButton2,   ///< The second extra mouse button

    sfMouseButtonCount ///< Keep last -- the total number of mouse buttons
} sfMouseButton;

//////////////////////
// Event
//////////////////////
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

typedef struct
{
    sfEventType   type;
    sfMouseButton button;
    int           x;
    int           y;
} sfMouseButtonEvent;

typedef struct
{
    sfEventType type;
    int         x;
    int         y;
} sfMouseMoveEvent;

typedef struct
{
    sfEventType  type;
    sfMouseWheel wheel;
    float        delta;
    int          x;
    int          y;
} sfMouseWheelScrollEvent;

typedef union
{
    sfEventType             type;             ///< Type of the event
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

//////////////////////////
/// FUNCTIONS RenderWindow
//////////////////////////

extern void sfRenderWindow_close(sfRenderWindow* renderWindow);

extern sfRenderWindow* sfRenderWindow_create(sfVideoMode mode, const char* title, sfUint32 style, const sfContextSettings* settings);

extern sfBool sfRenderWindow_isOpen(const sfRenderWindow* renderWindow);
extern sfBool sfRenderWindow_hasFocus(const sfRenderWindow* renderWindow);
extern sfBool sfRenderWindow_pollEvent(sfRenderWindow* renderWindow, sfEvent* event);

extern void sfRenderWindow_clear(sfRenderWindow* renderWindow, sfColor color);
extern void sfRenderWindow_destroy(sfRenderWindow* renderWindow);
extern void sfRenderWindow_display(sfRenderWindow* renderWindow);
extern void sfRenderWindow_drawShape(sfRenderWindow* renderWindow, const sfShape* object, const sfRenderStates* states);
extern void sfRenderWindow_drawCircleShape(sfRenderWindow* renderWindow, const sfCircleShape* object, const sfRenderStates* states);

///////////////////////////
/// FUNCTIONS Circle Shape
///////////////////////////

extern sfCircleShape* sfCircleShape_create(void);

extern void sfCircleShape_setRadius(sfCircleShape* shape, float radius);
extern void sfCircleShape_setFillColor(sfCircleShape* shape, sfColor color);
extern void sfCircleShape_setOutlineColor(sfCircleShape* shape, sfColor color);
extern void sfCircleShape_setOutlineThickness(sfCircleShape* shape, float thickness);
extern void sfCircleShape_destroy(sfCircleShape* shape);

//////////////////////
// FUNCTION Mouse
//////////////////////

extern sfBool sfMouse_isButtonPressed(sfMouseButton button);