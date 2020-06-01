<?php


namespace PHPML\Exception;

use Throwable;

class FFILoadingException extends \FFI\Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "Erreur de chargement de la bibliothèque vers FFI : \n\t" . $message;
        parent::__construct($message, $code, $previous);
    }
}