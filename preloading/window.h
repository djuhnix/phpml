#define FFI_SCOPE "WINDOW"
#define FFI_LIB "/usr/lib/x86_64-linux-gnu/libcsfml-window.so"

typedef int sfBool;

typedef struct
{
    unsigned int width;        ///< Video mode width, in pixels
    unsigned int height;       ///< Video mode height, in pixels
    unsigned int bitsPerPixel; ///< Video mode pixel depth, in bits per pixels
} sfVideoMode;

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

//////////////////////////
/// FUNCTIONS VideoMode
//////////////////////////

extern sfBool sfVideoMode_isValid(sfVideoMode mode);
extern sfVideoMode sfVideoMode_getDesktopMode(void);
//extern const sfVideoMode* sfVideoMode_getFullscreenModes(size_t* count);

//////////////////////
// FUNCTION Mouse
//////////////////////

extern sfBool sfMouse_isButtonPressed(sfMouseButton button);