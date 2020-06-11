<?php

namespace PHPML\Enum;

use FFI\CData;
use InvalidArgumentException;
use PHPML\AbstractFFI\MyCData;
use PHPML\Library\GraphicsLibLoader as Lib;

class Color extends CDataEnum
{
    use MyCData;

    const BLACK     = 'sfBlack';
    const WHITE     = 'sfWhite';
    const RED       = 'sfRed';
    const GREEN     = 'sfGreen';
    const BLUE      = 'sfBlue';

    const DYNAMIC   = 'Couleur Dynamique';

    private int $red;
    private int $green;
    private int $blue;
    private int $alpha;
    private bool $withAlpha = false;

    private function isColorArray(array $colors) : bool
    {
        $ret = true;
        if (count($colors) == 3) {
            foreach ($colors as $color) {
                if (!is_int($color) && ($color < 0 || $color > 255)) {
                    $ret = false;
                }
            }
        }
        return $ret;
    }

    /**
     * Instancie les valeur d'une couleur dynamique.
     *
     * @param int $red la valeur rouge de la couleur
     * @param int $green la valeur verte de la couleur
     * @param int $blue la valeur bleue de la couleur
     * @return $this|null l'instance de la couleur dynamique avec ses valeurs
     */
    public function fromRGB(int $red, int $green, int $blue) : ?self
    {
        if (!$this->isColorArray([$red, $green, $blue])) {
            throw new InvalidArgumentException("L'une des couleur entrées n'est pas correcte (comprise entre 0 et 255 inclue).");
        }
        if ($this->value != static::DYNAMIC) {
            throw new InvalidArgumentException("La couleur n'est pas dynamique pour pouvoir modifier sa valeur rouge.");
        }
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
        return $this;
    }

    /**
     * Instancie les valeur d'une couleur dynamique.
     *
     * @param int $red la valeur rouge de la couleur
     * @param int $green la valeur verte de la couleur
     * @param int $blue la valeur bleue de la couleur
     * @param int $alpha le canal alpha de la couleur
     * @return $this|null l'instance de la couleur dynamique avec ses valeurs
     */
    public function fromRGBA(int $red, int $green, int $blue, int $alpha) : ?self
    {
        if (!$this->isColorArray([$alpha])) {
            throw new InvalidArgumentException("La valeur du canal alpha n'est pas correcte (comprise entre 0 et 255 inclue).");
        }
        $this->alpha = $alpha;
        $this->withAlpha = true;
        return $this->fromRGB($red, $green, $blue);
    }

    /**
     * Accesseur à la valeur de la couleur rouge.
     *
     * @return int
     */
    public function getRed(): int
    {
        return $this->red;
    }

    /**
     * Modificateur de la couleur rouge.
     * Valide uniquement si la couleur est dynamique.
     *
     * @param int $red la nouvelle valeur de la couleur
     * @throws InvalidArgumentException si la couleur n'est pas dynamique
     */
    public function setRed(int $red): void
    {
        if ($this->value != static::DYNAMIC) {
            throw new InvalidArgumentException("La couleur n'est pas dynamique pour pouvoir modifier sa valeur rouge.");
        }
        $this->red = $red;
    }

    /**
     * Accesseur à la valeur de la couleur verte.
     *
     * @return int
     */
    public function getGreen(): int
    {
        return $this->green;
    }

    /**
     * Modificateur de la couleur verte.
     * Valide uniquement si la couleur est dynamique.
     *
     * @param int $green la nouvelle valeur de la couleur
     * @throws InvalidArgumentException si la couleur n'est pas dynamique
     */
    public function setGreen(int $green): void
    {
        if ($this->value != static::DYNAMIC) {
            throw new InvalidArgumentException("La couleur n'est pas dynamique pour pouvoir modifier sa valeur verte.");
        }
        $this->green = $green;
    }

    /**
     * Accesseur à la valeur de la couleur bleue
     *
     * @return int
     */
    public function getBlue(): int
    {
        return $this->blue;
    }

    /**
     * Modificateur de la couleur bleue.
     * Valide uniquement si la couleur est dynamique.
     *
     * @param int $blue la nouvelle valeur de la couleur
     * @throws InvalidArgumentException si la couleur n'est pas dynamique
     */
    public function setBlue(int $blue): void
    {
        if ($this->value != static::DYNAMIC) {
            throw new InvalidArgumentException("La couleur n'est pas dynamique pour pouvoir modifier sa valeur bleue.");
        }
        $this->blue = $blue;
    }

    /**
     * Accesseur au canal alpha de la couleur
     * @return int
     */
    public function getAlpha(): int
    {
        return $this->alpha;
    }

    /**
     * Modificateur du canal alpha de la couleur.
     * Valide uniquement si la couleur est dynamique.
     *
     * @param int $alpha
     */
    public function setAlpha(int $alpha): void
    {
        if ($this->value != static::DYNAMIC) {
            throw new InvalidArgumentException("La couleur n'est pas dynamique pour pouvoir modifier son canal alpha.");
        }
        $this->alpha = $alpha;
    }

    public static function toCDataValue(string $value)
    {
        if ($value == static::DYNAMIC) {
            throw new InvalidArgumentException("Une couleur dynamique ne peut pas être convertit en valeur C, utiliser 'toCData' à la place ou une autre valeur de l'énumération.");
        }
        return parent::toCDataValue($value);
    }

    /**
     * @inheritDoc
     */
    public function toCData() : CData
    {
        if ($this->value != self::DYNAMIC) {
            throw new InvalidArgumentException("La couleur n'est pas dynamique pour pouvoir la convertir en donnée C, utiliser une autre valeur de l'énumération ou la méthode 'toCDataValue' à la place.");
        }
        $this->cdata ??= Lib::getGraphicsLib()->new(
            Lib::getGraphicsLib()->type(CSFMLType::COLOR)
        );

        if ($this->withAlpha) {
            $this->cdata = Lib::getGraphicsLib()->sfColor_fromRGBA(
                $this->red,
                $this->green,
                $this->blue,
                $this->alpha
            );
        } else {
            $this->cdata = Lib::getGraphicsLib()->sfColor_fromRGB(
                $this->red,
                $this->green,
                $this->blue
            );
        }
        return $this->cdata;
    }

    /**
     * Retourne l'instance actuelle utilisable en tant que donnée C, selon que c'est une couleur dynamique ou prédéfinie.
     *
     * @return CData
     */
    public function getCDataColor(): CData
    {
        if ($this->getValue() == Color::DYNAMIC) {
            $color = $this->toCData();
        } else {
            $color = $this->toCDataValue($this->getValue());
        }
        return $color;
    }
}
