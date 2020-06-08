#define FFI_SCOPE "WINDOW"
#define FFI_LIB "/usr/lib/x86_64-linux-gnu/libcsfml-window.so"

typedef int sfBool;

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
// FUNCTION Mouse
//////////////////////

extern sfBool sfMouse_isButtonPressed(sfMouseButton button);