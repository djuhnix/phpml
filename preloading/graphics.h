#define FFI_SCOPE "GRAPHICS"
#define FFI_LIB "/usr/lib/x86_64-linux-gnu/libcsfml-graphics.so"

typedef unsigned char sfUint8;
typedef unsigned int sfUint32;
typedef int sfBool;

typedef struct sfVector2f
{
    float x;
    float y;
 } sfVector2f;

typedef struct sfVector2i
{
    int x;
    int y;
 } sfVector2i;

typedef struct sfVector2u
{
    unsigned int x;
    unsigned int y;
} sfVector2u;

typedef struct sfIntRect
{
    int left;
    int top;
    int width;
    int height;
} sfIntRect;

typedef struct sfFloatRect
{
    float left;
    float top;
    float width;
    float height;
} sfFloatRect;

typedef struct sfFont
{
    int placebo_sfFont;
} sfFont;

typedef struct sfText
{
    const sfFont*       Font;
} sfText;


typedef struct sfView
{
    int placebo_sfView;
} sfView;

typedef struct sfRenderStates
{
    int placebo_sfRenderStates;
    //sfBlendMode      blendMode; ///< Blending mode
    //sfTransform      transform; ///< Transform
    //const sfTexture* texture;   ///< Texture
    //const sfShader*  shader;    ///< Shader
} sfRenderStates;

typedef struct sfTexture
{
    int placebo_sfTexture;
} sfTexture;

typedef struct sfColor
{
    sfUint8 r;
    sfUint8 g;
    sfUint8 b;
    sfUint8 a;
} sfColor;

//////////////////
// Shape & Sprite
//////////////////
typedef struct sfVertex
{
    sfVector2f position;  ///< Position of the vertex
    sfColor    color;     ///< Color of the vertex
    sfVector2f texCoords; ///< Coordinates of the texture's pixel to map to the vertex
} sfVertex;

typedef struct sfSprite
{
    const sfTexture*    Texture;
} sfSprite;

typedef struct sfConvexShape
{
    const sfTexture*    Texture;
} sfConvexShape;

typedef struct sfShape
{
    const sfTexture*    Texture;
} sfShape;

typedef struct sfCircleShape
{
    const sfTexture*    Texture;
} sfCircleShape;

typedef struct sfRectangleShape
{
    const sfTexture*    Texture;
} sfRectangleShape;

typedef struct sfRenderWindow
{
    sfView           DefaultView;
    sfView           CurrentView;
} sfRenderWindow;

typedef struct sfVideoMode
{
    unsigned int width;        ///< Video mode width, in pixels
    unsigned int height;       ///< Video mode height, in pixels
    unsigned int bitsPerPixel; ///< Video mode pixel depth, in bits per pixels
} sfVideoMode;

/////////////////////
// Color
////////////////////

sfColor sfBlack;       ///< Black predefined color
sfColor sfWhite;       ///< White predefined color
sfColor sfRed;         ///< Red predefined color
sfColor sfGreen;       ///< Green predefined color
sfColor sfBlue;        ///< Blue predefined color
sfColor sfYellow;      ///< Yellow predefined color
sfColor sfMagenta;     ///< Magenta predefined color
sfColor sfCyan;        ///< Cyan predefined color
sfColor sfTransparent; ///< Transparent (black) predefined color

//////////////////////
// Style
//////////////////////
typedef enum
{
    sfTextRegular       = 0,      ///< Regular characters, no style
    sfTextBold          = 1 << 0, ///< Bold characters
    sfTextItalic        = 1 << 1, ///< Italic characters
    sfTextUnderlined    = 1 << 2, ///< Underlined characters
    sfTextStrikeThrough = 1 << 3  ///< Strike through characters
} sfTextStyle;

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

typedef struct sfKeyEvent
{
    sfEventType type;
    sfKeyCode   code;
    sfBool      alt;
    sfBool      control;
    sfBool      shift;
    sfBool      system;
} sfKeyEvent;

typedef struct sfMouseButtonEvent
{
    sfEventType   type;
    sfMouseButton button;
    int           x;
    int           y;
} sfMouseButtonEvent;

typedef struct sfMouseMoveEvent
{
    sfEventType type;
    int         x;
    int         y;
} sfMouseMoveEvent;

typedef struct sfMouseWheelScrollEvent
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

typedef struct sfContextSettings
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
extern sfBool sfRenderWindow_setActive(sfRenderWindow* renderWindow, sfBool active);

extern void sfRenderWindow_requestFocus(sfRenderWindow* renderWindow);
extern void sfRenderWindow_clear(sfRenderWindow* renderWindow, sfColor color);
extern void sfRenderWindow_destroy(sfRenderWindow* renderWindow);
extern void sfRenderWindow_display(sfRenderWindow* renderWindow);

// drawing functions
extern void sfRenderWindow_drawShape(sfRenderWindow* renderWindow, const sfShape* object, const sfRenderStates* states);
extern void sfRenderWindow_drawSprite(sfRenderWindow* renderWindow, const sfSprite* object, const sfRenderStates* states);
extern void sfRenderWindow_drawText(sfRenderWindow* renderWindow, const sfText* object, const sfRenderStates* states);
extern void sfRenderWindow_drawCircleShape(sfRenderWindow* renderWindow, const sfCircleShape* object, const sfRenderStates* states);
extern void sfRenderWindow_drawRectangleShape(sfRenderWindow* renderWindow, const sfRectangleShape* object, const sfRenderStates* states);
extern void sfRenderWindow_drawConvexShape(sfRenderWindow* renderWindow, const sfConvexShape* object, const sfRenderStates* states);

extern sfVector2f sfRenderWindow_mapPixelToCoords(const sfRenderWindow* renderWindow, sfVector2i point, const sfView* view);

extern sfVector2i sfMouse_getPositionRenderWindow(const sfRenderWindow* relativeTo);

///////////////////////////
/// FUNCTIONS Rect
///////////////////////////

extern sfBool sfIntRect_contains(const sfIntRect* rect, int x, int y);
extern sfBool sfIntRect_intersects(const sfIntRect* rect1, const sfIntRect* rect2, sfIntRect* intersection);

extern sfBool sfFloatRect_contains(const sfFloatRect* rect, float x, float y);
extern sfBool sfFloatRect_intersects(const sfFloatRect* rect1, const sfFloatRect* rect2, sfFloatRect* intersection);

///////////////////////////
/// FUNCTIONS Texture
///////////////////////////

extern sfTexture* sfTexture_copy(const sfTexture* texture);
extern sfTexture* sfTexture_create(unsigned int width, unsigned int height);
extern sfTexture* sfTexture_createFromFile(const char* filename, const sfIntRect* area);
//extern sfTexture* sfTexture_createFromImage(const sfImage* image, const sfIntRect* area);

extern void sfTexture_destroy(sfTexture* texture);
//extern void sfTexture_updateFromImage(sfTexture* texture, const sfImage* image, unsigned int x, unsigned int y);
//extern void sfTexture_updateFromWindow(sfTexture* texture, const sfWindow* window, unsigned int x, unsigned int y);
extern void sfTexture_setSmooth(sfTexture* texture, sfBool smooth);
extern void sfTexture_setRepeated(sfTexture* texture, sfBool repeated);
extern void sfTexture_swap(sfTexture* left, sfTexture* right);

extern sfVector2u sfTexture_getSize(const sfTexture* texture);
extern unsigned int sfTexture_getMaximumSize();
extern sfBool sfTexture_isSmooth(const sfTexture* texture);
extern sfBool sfTexture_isRepeated(const sfTexture* texture);

///////////////////////////
// FUNCTIONS Shape
///////////////////////////
typedef size_t (*sfShapeGetPointCountCallback)(void*);        ///< Type of the callback used to get the number of points in a shape
typedef sfVector2f (*sfShapeGetPointCallback)(size_t, void*); ///< Type of the callback used to get a point of a shape

extern sfShape* sfShape_create(sfShapeGetPointCountCallback getPointCount,
                               sfShapeGetPointCallback getPoint,
                               void* userData);

extern void sfShape_destroy(sfShape* shape);

extern float sfShape_getRotation(const sfShape* shape);

extern float sfShape_getOutlineThickness(const sfShape* shape);
extern size_t sfShape_getPointCount(const sfShape* shape);

extern sfVector2f sfShape_getPoint(const sfShape* shape, size_t index);
extern sfVector2f sfShape_getPosition(const sfShape* shape);
extern sfVector2f sfShape_getScale(const sfShape* shape);
extern sfVector2f sfShape_getOrigin(const sfShape* shape);

extern sfTexture* sfShape_getTexture(const sfShape* shape);
extern sfIntRect sfShape_getTextureRect(const sfShape* shape);

extern sfColor sfShape_getFillColor(const sfShape* shape);
extern sfColor sfShape_getOutlineColor(const sfShape* shape);

extern void sfShape_move(sfShape* shape, sfVector2f offset);
extern void sfShape_rotate(sfShape* shape, float angle);
extern void sfShape_scale(sfShape* shape, sfVector2f factors);

extern void sfShape_setTexture(sfShape* shape, const sfTexture* texture, sfBool resetRect);
extern void sfShape_setTextureRect(sfShape* shape, sfIntRect rect);
extern void sfShape_setFillColor(sfShape* shape, sfColor color);
extern void sfShape_setPosition(sfShape* shape, sfVector2f position);
extern void sfShape_setRotation(sfShape* shape, float angle);
extern void sfShape_setScale(sfShape* shape, sfVector2f scale);
extern void sfShape_setOrigin(sfShape* shape, sfVector2f origin);
extern void sfShape_setOutlineColor(sfShape* shape, sfColor color);
extern void sfShape_setOutlineThickness(sfShape* shape, float thickness);

extern void sfShape_update(sfShape* shape);

extern sfFloatRect sfShape_getGlobalBounds(const sfShape* shape);

///////////////////////////
// FUNCTIONS Font
///////////////////////////

extern sfFont* sfFont_createFromFile(const char* filename);
extern sfFont* sfFont_copy(const sfFont* font);
extern void sfFont_destroy(sfFont* font);

///////////////////////////
// FUNCTIONS Text
///////////////////////////
extern sfText* sfText_create(void);
extern sfText* sfText_copy(const sfText* text);

extern sfVector2f sfText_getScale(const sfText* text);
extern sfVector2f sfText_getOrigin(const sfText* text);
extern sfVector2f sfText_getPosition(const sfText* text);
extern sfVector2f sfText_findCharacterPos(const sfText* text, size_t index);

extern float sfText_getRotation(const sfText* text);

extern void sfText_destroy(sfText* text);

extern void sfText_move(sfText* text, sfVector2f offset);
extern void sfText_rotate(sfText* text, float angle);
extern void sfText_scale(sfText* text, sfVector2f factors);

extern sfUint32 sfText_getStyle(const sfText* text);
//extern float sfText_getLineSpacing(const sfText* text);
extern const sfFont* sfText_getFont(const sfText* text);
extern const char* sfText_getString(const sfText* text);
extern float sfText_getLetterSpacing(const sfText* text);
extern unsigned int sfText_getCharacterSize(const sfText* text);
extern const sfUint32* sfText_getUnicodeString(const sfText* text);

extern sfColor sfText_getColor(const sfText* text);
extern sfColor sfText_getFillColor(const sfText* text);
extern sfColor sfText_getOutlineColor(const sfText* text);
extern float sfText_getOutlineThickness(const sfText* text);

extern void sfText_setFillColor(sfText* text, sfColor color);
extern void sfText_setOutlineColor(sfText* text, sfColor color);
extern void sfText_setOutlineThickness(sfText* text, float thickness);

extern void sfText_setString(sfText* text, const char* string);
extern void sfText_setUnicodeString(sfText* text, const sfUint32* string);
extern void sfText_setFont(sfText* text, const sfFont* font);
extern void sfText_setCharacterSize(sfText* text, unsigned int size);
extern void sfText_setLineSpacing(sfText* text, float spacingFactor);
extern void sfText_setLetterSpacing(sfText* text, float spacingFactor);
extern void sfText_setStyle(sfText* text, sfUint32 style);
extern void sfText_setColor(sfText* text, sfColor color);

extern void sfText_setScale(sfText* text, sfVector2f scale);
extern void sfText_setRotation(sfText* text, float angle);
extern void sfText_setPosition(sfText* text, sfVector2f position);

extern sfFloatRect sfText_getGlobalBounds(const sfText* text);

///////////////////////////
/// FUNCTIONS Sprite
///////////////////////////

extern sfSprite* sfSprite_create(void);
extern sfSprite* sfSprite_copy(const sfSprite* sprite);

extern sfVector2f sfSprite_getPosition(const sfSprite* sprite);
extern sfVector2f sfSprite_getScale(const sfSprite* sprite);

extern const sfTexture* sfSprite_getTexture(const sfSprite* sprite);
extern float sfSprite_getRotation(const sfSprite* sprite);

extern void sfSprite_destroy(sfSprite* sprite);

extern void sfSprite_move(sfSprite* sprite, sfVector2f offset);
extern void sfSprite_rotate(sfSprite* sprite, float angle);
extern void sfSprite_scale(sfSprite* sprite, sfVector2f factors);

extern void sfSprite_setColor(sfSprite* sprite, sfColor color);
extern void sfSprite_setTexture(sfSprite* sprite, const sfTexture* texture, sfBool resetRect);
extern void sfSprite_setPosition(sfSprite* sprite, sfVector2f position);
extern void sfSprite_setRotation(sfSprite* sprite, float angle);
extern void sfSprite_setScale(sfSprite* sprite, sfVector2f scale);
extern void sfSprite_setOrigin(sfSprite* sprite, sfVector2f origin);

extern sfFloatRect sfSprite_getGlobalBounds(const sfSprite* sprite);

///////////////////////////
/// FUNCTIONS Circle Shape
///////////////////////////

extern sfCircleShape* sfCircleShape_create(void);

extern void sfCircleShape_destroy(sfCircleShape* shape);

extern float sfCircleShape_getRadius(sfCircleShape* shape);
extern float sfCircleShape_getRotation(const sfCircleShape* shape);
extern float sfCircleShape_getOutlineThickness(const sfCircleShape* shape);

extern sfVector2f sfCircleShape_getPosition(sfCircleShape* shape);
extern sfVector2f sfCircleShape_getScale(const sfCircleShape* shape);
extern sfTexture* sfCircleShape_getTexture(const sfCircleShape* shape);

extern sfColor sfCircleShape_getFillColor(const sfCircleShape* shape);
extern sfColor sfCircleShape_getOutlineColor(const sfCircleShape* shape);

extern sfIntRect sfCircleShape_getTextureRect(const sfCircleShape* shape);
extern sfVector2f sfCircleShape_getOrigin(const sfCircleShape* shape);
extern sfVector2f sfCircleShape_getPoint(const sfCircleShape* shape, size_t index);
extern size_t sfCircleShape_getPointCount(const sfCircleShape* shape);

extern void sfCircleShape_scale(sfCircleShape* shape, sfVector2f factors);
extern void sfCircleShape_rotate(sfCircleShape* shape, float angle);
extern void sfCircleShape_move(sfCircleShape* shape, sfVector2f offset);

extern void sfCircleShape_setRadius(sfCircleShape* shape, float radius);

extern void sfCircleShape_setScale(sfCircleShape* shape, sfVector2f factors);
extern void sfCircleShape_setRotation(sfCircleShape* shape, float angle);
extern void sfCircleShape_setTexture(sfCircleShape* shape, const sfTexture* texture, sfBool resetRect);
extern void sfCircleShape_setTextureRect(sfCircleShape* shape, sfIntRect rect);
extern void sfCircleShape_setPosition(sfCircleShape* shape, sfVector2f position);
extern void sfCircleShape_setFillColor(sfCircleShape* shape, sfColor color);
extern void sfCircleShape_setOutlineColor(sfCircleShape* shape, sfColor color);
extern void sfCircleShape_setOutlineThickness(sfCircleShape* shape, float thickness);
extern void sfCircleShape_setOrigin(sfCircleShape* shape, sfVector2f origin);
extern void sfCircleShape_setPointCount(sfCircleShape* shape, size_t count);

extern sfFloatRect sfCircleShape_getGlobalBounds(const sfCircleShape* shape);

///////////////////////////
/// FUNCTIONS Rectangle Shape
///////////////////////////

extern sfRectangleShape* sfRectangleShape_create(void);

extern void sfRectangleShape_destroy(sfRectangleShape* shape);

extern sfVector2f sfRectangleShape_getPosition(const sfRectangleShape* shape);
extern sfVector2f sfRectangleShape_getSize(const sfRectangleShape* shape);

extern sfTexture* sfRectangleShape_getTexture(const sfRectangleShape* shape);
extern sfIntRect sfRectangleShape_getTextureRect(const sfRectangleShape* shape);
extern sfColor sfRectangleShape_getFillColor(const sfRectangleShape* shape);
extern sfColor sfRectangleShape_getOutlineColor(const sfRectangleShape* shape);

extern float sfRectangleShape_getOutlineThickness(const sfRectangleShape* shape);
extern float sfRectangleShape_getRotation(const sfRectangleShape* shape);

extern sfVector2f sfRectangleShape_getScale(const sfRectangleShape* shape);
extern sfVector2f sfRectangleShape_getOrigin(const sfRectangleShape* shape);
extern size_t sfRectangleShape_getPointCount(const sfRectangleShape* shape);
extern sfVector2f sfRectangleShape_getPoint(const sfRectangleShape* shape, size_t index);

extern void sfRectangleShape_move(sfRectangleShape* shape, sfVector2f offset);
extern void sfRectangleShape_scale(sfRectangleShape* shape, sfVector2f factors);
extern void sfRectangleShape_rotate(sfRectangleShape* shape, float angle);

extern void sfRectangleShape_setSize(sfRectangleShape* shape, sfVector2f size);

extern void sfRectangleShape_setScale(sfRectangleShape* shape, sfVector2f factors);
extern void sfRectangleShape_setRotation(sfRectangleShape* shape, float angle);
extern void sfRectangleShape_setTexture(sfRectangleShape* shape, const sfTexture* texture, sfBool resetRect);
extern void sfRectangleShape_setTextureRect(sfRectangleShape* shape, sfIntRect rect);
extern void sfRectangleShape_setPosition(sfRectangleShape* shape, sfVector2f position);
extern void sfRectangleShape_setFillColor(sfRectangleShape* shape, sfColor color);
extern void sfRectangleShape_setOutlineColor(sfRectangleShape* shape, sfColor color);
extern void sfRectangleShape_setOutlineThickness(sfRectangleShape* shape, float thickness);
extern void sfRectangleShape_setOrigin(sfRectangleShape* shape, sfVector2f origin);

extern sfFloatRect sfRectangleShape_getGlobalBounds(const sfRectangleShape* shape);

///////////////////////////
/// FUNCTIONS Convex Shape
///////////////////////////
extern sfConvexShape* sfConvexShape_create(void);
extern sfConvexShape* sfConvexShape_copy(const sfConvexShape* shape);

extern void sfConvexShape_destroy(sfConvexShape* shape);

extern sfVector2f sfConvexShape_getPosition(const sfConvexShape* shape);
extern sfVector2f sfConvexShape_getScale(const sfConvexShape* shape);
extern sfVector2f sfConvexShape_getOrigin(const sfConvexShape* shape);
extern sfVector2f sfConvexShape_getPoint(const sfConvexShape* shape, size_t index);
extern size_t sfConvexShape_getPointCount(const sfConvexShape* shape);

extern const sfTexture* sfConvexShape_getTexture(const sfConvexShape* shape);
extern sfIntRect sfConvexShape_getTextureRect(const sfConvexShape* shape);

extern float sfConvexShape_getRotation(const sfConvexShape* shape);
extern float sfConvexShape_getOutlineThickness(const sfConvexShape* shape);

extern sfColor sfConvexShape_getFillColor(const sfConvexShape* shape);
extern sfColor sfConvexShape_getOutlineColor(const sfConvexShape* shape);

extern void sfConvexShape_move(sfConvexShape* shape, sfVector2f offset);
extern void sfConvexShape_rotate(sfConvexShape* shape, float angle);
extern void sfConvexShape_scale(sfConvexShape* shape, sfVector2f factors);

extern void sfConvexShape_setTexture(sfConvexShape* shape, const sfTexture* texture, sfBool resetRect);
extern void sfConvexShape_setTextureRect(sfConvexShape* shape, sfIntRect rect);
extern void sfConvexShape_setFillColor(sfConvexShape* shape, sfColor color);
extern void sfConvexShape_setPosition(sfConvexShape* shape, sfVector2f position);
extern void sfConvexShape_setRotation(sfConvexShape* shape, float angle);
extern void sfConvexShape_setScale(sfConvexShape* shape, sfVector2f scale);
extern void sfConvexShape_setOrigin(sfConvexShape* shape, sfVector2f origin);
extern void sfConvexShape_setOutlineColor(sfConvexShape* shape, sfColor color);
extern void sfConvexShape_setOutlineThickness(sfConvexShape* shape, float thickness);
extern void sfConvexShape_setPointCount(sfConvexShape* shape, size_t count);
extern void sfConvexShape_setPoint(sfConvexShape* shape, size_t index, sfVector2f point);

extern sfFloatRect sfConvexShape_getGlobalBounds(const sfConvexShape* shape);
