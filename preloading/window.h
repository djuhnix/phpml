#define FFI_SCOPE "WINDOW"
#define FFI_LIB "/usr/lib/x86_64-linux-gnu/libcsfml-window.so"

typedef int sfBool;

//////////////////////////
/// VideoMode
//////////////////////////

typedef struct
{
    unsigned int width;        ///< Video mode width, in pixels
    unsigned int height;       ///< Video mode height, in pixels
    unsigned int bitsPerPixel; ///< Video mode pixel depth, in bits per pixels
} sfVideoMode;

extern sfBool sfVideoMode_isValid(sfVideoMode mode);
extern sfVideoMode sfVideoMode_getDesktopMode(void);
//extern const sfVideoMode* sfVideoMode_getFullscreenModes(size_t* count);

//////////////////////
// Mouse
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

extern sfBool sfMouse_isButtonPressed(sfMouseButton button);

//////////////////////
// FUNCTION Keyboard
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

extern sfBool sfKeyboard_isKeyPressed(sfKeyCode key);