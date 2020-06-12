#define FFI_SCOPE "GRAPHICS"
#define FFI_LIB "/usr/lib/x86_64-linux-gnu/libcsfml-graphics.so"

typedef unsigned char sfUint8;
typedef unsigned int sfUint32;
typedef int sfBool;

typedef struct
{
    float x;
    float y;
 } sfVector2f;

typedef struct
{
    int x;
    int y;
 } sfVector2i;

typedef struct
{
    unsigned int x;
    unsigned int y;
} sfVector2u;

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

typedef struct {
    int placebo_sfRectangleShape;
} sfRectangleShape;

typedef struct
{
    int placebo_sfRenderWindow;
} sfRenderWindow;

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

typedef enum
{
    sfMouseVerticalWheel,  ///< The vertical mouse wheel
    sfMouseHorizontalWheel ///< The horizontal mouse wheel
} sfMouseWheel;

//////////////////////
// Keyboard
//////////////////////

typedef enum
{
    sfKeyUnknown = -1, ///< Unhandled key
    sfKeyA,            ///< The A key
    sfKeyB,            ///< The B key
    sfKeyC,            ///< The C key
    sfKeyD,            ///< The D key
    sfKeyE,            ///< The E key
    sfKeyF,            ///< The F key
    sfKeyG,            ///< The G key
    sfKeyH,            ///< The H key
    sfKeyI,            ///< The I key
    sfKeyJ,            ///< The J key
    sfKeyK,            ///< The K key
    sfKeyL,            ///< The L key
    sfKeyM,            ///< The M key
    sfKeyN,            ///< The N key
    sfKeyO,            ///< The O key
    sfKeyP,            ///< The P key
    sfKeyQ,            ///< The Q key
    sfKeyR,            ///< The R key
    sfKeyS,            ///< The S key
    sfKeyT,            ///< The T key
    sfKeyU,            ///< The U key
    sfKeyV,            ///< The V key
    sfKeyW,            ///< The W key
    sfKeyX,            ///< The X key
    sfKeyY,            ///< The Y key
    sfKeyZ,            ///< The Z key
    sfKeyNum0,         ///< The 0 key
    sfKeyNum1,         ///< The 1 key
    sfKeyNum2,         ///< The 2 key
    sfKeyNum3,         ///< The 3 key
    sfKeyNum4,         ///< The 4 key
    sfKeyNum5,         ///< The 5 key
    sfKeyNum6,         ///< The 6 key
    sfKeyNum7,         ///< The 7 key
    sfKeyNum8,         ///< The 8 key
    sfKeyNum9,         ///< The 9 key
    sfKeyEscape,       ///< The Escape key
    sfKeyLControl,     ///< The left Control key
    sfKeyLShift,       ///< The left Shift key
    sfKeyLAlt,         ///< The left Alt key
    sfKeyLSystem,      ///< The left OS specific key: window (Windows and Linux), apple (MacOS X), ...
    sfKeyRControl,     ///< The right Control key
    sfKeyRShift,       ///< The right Shift key
    sfKeyRAlt,         ///< The right Alt key
    sfKeyRSystem,      ///< The right OS specific key: window (Windows and Linux), apple (MacOS X), ...
    sfKeyMenu,         ///< The Menu key
    sfKeyLBracket,     ///< The [ key
    sfKeyRBracket,     ///< The ] key
    sfKeySemicolon,    ///< The ; key
    sfKeyComma,        ///< The , key
    sfKeyPeriod,       ///< The . key
    sfKeyQuote,        ///< The ' key
    sfKeySlash,        ///< The / key
    sfKeyBackslash,    ///< The \ key
    sfKeyTilde,        ///< The ~ key
    sfKeyEqual,        ///< The = key
    sfKeyHyphen,       ///< The - key (hyphen)
    sfKeySpace,        ///< The Space key
    sfKeyEnter,        ///< The Enter/Return key
    sfKeyBackspace,    ///< The Backspace key
    sfKeyTab,          ///< The Tabulation key
    sfKeyPageUp,       ///< The Page up key
    sfKeyPageDown,     ///< The Page down key
    sfKeyEnd,          ///< The End key
    sfKeyHome,         ///< The Home key
    sfKeyInsert,       ///< The Insert key
    sfKeyDelete,       ///< The Delete key
    sfKeyAdd,          ///< The + key
    sfKeySubtract,     ///< The - key (minus, usually from numpad)
    sfKeyMultiply,     ///< The * key
    sfKeyDivide,       ///< The / key
    sfKeyLeft,         ///< Left arrow
    sfKeyRight,        ///< Right arrow
    sfKeyUp,           ///< Up arrow
    sfKeyDown,         ///< Down arrow
    sfKeyNumpad0,      ///< The numpad 0 key
    sfKeyNumpad1,      ///< The numpad 1 key
    sfKeyNumpad2,      ///< The numpad 2 key
    sfKeyNumpad3,      ///< The numpad 3 key
    sfKeyNumpad4,      ///< The numpad 4 key
    sfKeyNumpad5,      ///< The numpad 5 key
    sfKeyNumpad6,      ///< The numpad 6 key
    sfKeyNumpad7,      ///< The numpad 7 key
    sfKeyNumpad8,      ///< The numpad 8 key
    sfKeyNumpad9,      ///< The numpad 9 key
    sfKeyF1,           ///< The F1 key
    sfKeyF2,           ///< The F2 key
    sfKeyF3,           ///< The F3 key
    sfKeyF4,           ///< The F4 key
    sfKeyF5,           ///< The F5 key
    sfKeyF6,           ///< The F6 key
    sfKeyF7,           ///< The F7 key
    sfKeyF8,           ///< The F8 key
    sfKeyF9,           ///< The F8 key
    sfKeyF10,          ///< The F10 key
    sfKeyF11,          ///< The F11 key
    sfKeyF12,          ///< The F12 key
    sfKeyF13,          ///< The F13 key
    sfKeyF14,          ///< The F14 key
    sfKeyF15,          ///< The F15 key
    sfKeyPause,        ///< The Pause key

    sfKeyCount,      ///< Keep last -- the total number of keyboard keys

    // Deprecated values:

    sfKeyDash      = sfKeyHyphen,       ///< \deprecated Use Hyphen instead
    sfKeyBack      = sfKeyBackspace,    ///< \deprecated Use Backspace instead
    sfKeyBackSlash = sfKeyBackslash,    ///< \deprecated Use Backslash instead
    sfKeySemiColon = sfKeySemicolon,    ///< \deprecated Use Semicolon instead
    sfKeyReturn    = sfKeyEnter         ///< \deprecated Use Enter instead
} sfKeyCode;

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
    sfEventType type;
    sfKeyCode   code;
    sfBool      alt;
    sfBool      control;
    sfBool      shift;
    sfBool      system;
} sfKeyEvent;

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
    //sfSizeEvent             size;             ///< Size event parameters
    sfKeyEvent              key;              ///< Key event parameters
    //sfTextEvent             text;             ///< Text event parameters
    sfMouseMoveEvent        mouseMove;        ///< Mouse move event parameters
    sfMouseButtonEvent      mouseButton;      ///< Mouse button event parameters
    //sfMouseWheelEvent       mouseWheel;       ///< Mouse wheel event parameters (deprecated)
    sfMouseWheelScrollEvent mouseWheelScroll; ///< Mouse wheel event parameters
    //sfJoystickMoveEvent     joystickMove;     ///< Joystick move event parameters
    //sfJoystickButtonEvent   joystickButton;   ///< Joystick button event parameters
    //sfJoystickConnectEvent  joystickConnect;  ///< Joystick (dis)connect event parameters
    //sfTouchEvent            touch;            ///< Touch events parameters
    //sfSensorEvent           sensor;           ///< Sensor event parameters
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
/// FUNCTIONS Color
//////////////////////////

extern sfColor sfColor_fromRGB(sfUint8 red, sfUint8 green, sfUint8 blue);
extern sfColor sfColor_fromRGBA(sfUint8 red, sfUint8 green, sfUint8 blue, sfUint8 alpha);

//////////////////////////
/// FUNCTIONS RenderWindow
//////////////////////////

extern void sfRenderWindow_close(sfRenderWindow* renderWindow);

extern sfRenderWindow* sfRenderWindow_create(sfVideoMode mode, const char* title, sfUint32 style, const sfContextSettings* settings);

extern sfBool sfRenderWindow_isOpen(const sfRenderWindow* renderWindow);
extern sfBool sfRenderWindow_hasFocus(const sfRenderWindow* renderWindow);
extern sfBool sfRenderWindow_pollEvent(sfRenderWindow* renderWindow, sfEvent* event);

extern sfVector2u sfRenderWindow_getSize(const sfRenderWindow* renderWindow);
extern sfVector2i sfRenderWindow_getPosition(const sfRenderWindow* renderWindow);

extern void sfRenderWindow_setSize(sfRenderWindow* renderWindow, sfVector2u size);
extern void sfRenderWindow_setPosition(sfRenderWindow* renderWindow, sfVector2i position);

extern void sfRenderWindow_clear(sfRenderWindow* renderWindow, sfColor color);
extern void sfRenderWindow_destroy(sfRenderWindow* renderWindow);
extern void sfRenderWindow_display(sfRenderWindow* renderWindow);

// drawing functions
extern void sfRenderWindow_drawShape(sfRenderWindow* renderWindow, const sfShape* object, const sfRenderStates* states);
extern void sfRenderWindow_drawCircleShape(sfRenderWindow* renderWindow, const sfCircleShape* object, const sfRenderStates* states);
extern void sfRenderWindow_drawRectangleShape(sfRenderWindow* renderWindow, const sfRectangleShape* object, const sfRenderStates* states);

///////////////////////////
/// FUNCTIONS Texture
///////////////////////////

///////////////////////////
/// FUNCTIONS Circle Shape
///////////////////////////

extern sfCircleShape* sfCircleShape_create(void);

extern void sfCircleShape_destroy(sfCircleShape* shape);

extern float sfCircleShape_getRadius(sfCircleShape* shape);
extern float sfCircleShape_getOutlineThickness(const sfCircleShape* shape);

extern sfVector2f sfCircleShape_getPosition(sfCircleShape* shape);

extern sfColor sfCircleShape_getFillColor(const sfCircleShape* shape);
extern sfColor sfCircleShape_getOutlineColor(const sfCircleShape* shape);

extern void sfCircleShape_move(sfCircleShape* shape, sfVector2f offset);
extern void sfCircleShape_setRadius(sfCircleShape* shape, float radius);
extern void sfCircleShape_setTexture(sfCircleShape* shape, const sfTexture* texture, sfBool resetRect);
extern void sfCircleShape_setPosition(sfCircleShape* shape, sfVector2f position);
extern void sfCircleShape_setFillColor(sfCircleShape* shape, sfColor color);
extern void sfCircleShape_setOutlineColor(sfCircleShape* shape, sfColor color);
extern void sfCircleShape_setOutlineThickness(sfCircleShape* shape, float thickness);


///////////////////////////
/// FUNCTIONS Rectangle Shape
///////////////////////////

extern sfRectangleShape* sfRectangleShape_create(void);

extern void sfRectangleShape_destroy(sfRectangleShape* shape);

extern sfVector2f sfRectangleShape_getPosition(const sfRectangleShape* shape);
extern sfVector2f sfRectangleShape_getSize(const sfRectangleShape* shape);

extern sfColor sfRectangleShape_getFillColor(const sfRectangleShape* shape);
extern sfColor sfRectangleShape_getOutlineColor(const sfRectangleShape* shape);

extern float sfRectangleShape_getOutlineThickness(const sfRectangleShape* shape);

extern void sfRectangleShape_move(sfRectangleShape* shape, sfVector2f offset);
extern void sfRectangleShape_setSize(sfRectangleShape* shape, sfVector2f size);
extern void sfRectangleShape_setTexture(sfRectangleShape* shape, const sfTexture* texture, sfBool resetRect);
extern void sfRectangleShape_setPosition(sfRectangleShape* shape, sfVector2f position);
extern void sfRectangleShape_setFillColor(sfRectangleShape* shape, sfColor color);
extern void sfRectangleShape_setOutlineColor(sfRectangleShape* shape, sfColor color);
extern void sfRectangleShape_setOutlineThickness(sfRectangleShape* shape, float thickness);
