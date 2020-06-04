<?php


namespace PHPML\Exception;

use FFI\Exception;
use Throwable;

class CDataException extends Exception
{

    /**
     * CDataException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "Erreur de donnée C : \n\t" . $message;
        parent::__construct($message, $code, $previous);
    }
}
