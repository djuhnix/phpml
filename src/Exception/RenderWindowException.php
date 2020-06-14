<?php


namespace PHPML\Exception;

use Throwable;

class RenderWindowException extends \FFI\Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "Erreur relative à la fenêtre : \n\t" . $message;
        parent::__construct($message, $code, $previous);
    }
}
