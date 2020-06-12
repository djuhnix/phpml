<?php


namespace PHPML\Graphics;

use PHPML\Enum\CSFMLType;

class FloatPosition extends Position
{
    /**
     * @inheritDoc
     */
    protected function getPositionType(): string
    {
        return CSFMLType::VECTOR_2F;
    }
}
