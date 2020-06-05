<?php

namespace PHPML\Enum;

use InvalidArgumentException;
use MyCLabs\Enum\Enum;
use PHPML\Graphics\GraphicsLibLoader as Lib;

class CDataEnum extends Enum
{
    /**
     * Retourne une instance de CDataEnum selon la valeur de l'énumaration
     * @param string $value
     * @return CDataEnum
     */
    public static function getFromCDataValue(string $value) : CDataEnum
    {
        if (!static::isValid($value)) {
            throw new InvalidArgumentException("La valeur entrée ne fait pas partie de l'énumération.");
        }
        return new static($value);
    }
    /**
     * Convertit une valeur de l'énumération en valeur utilisable avec la bibliothèque.
     *
     * @param string $value Valeur à convertir
     * @return mixed
     * @throws InvalidArgumentException si la valeur passée en paramètre ne fait pas partie de l'énumération
     */
    public static function toCDataValue(string $value)
    {
        if (!static::isValid($value)) {
            throw new InvalidArgumentException("La valeur entrée ne fait pas partie de l'énumération.");
        }
        return Lib::getGraphicsLib()->{$value};
    }
}
