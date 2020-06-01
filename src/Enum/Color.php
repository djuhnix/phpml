<?php


namespace PHPML\Enum;

use InvalidArgumentException;
use MyCLabs\Enum\Enum;
use PHPML\AbstractFFI;

class Color extends Enum
{
    use AbstractFFI;

    const BLACK     = 'sfBlack';
    const WHITE     = 'sfWhite';
    const RED       = 'sfRed';
    const GREEN     = 'sfGreen';
    const BLUE      = 'sfBlue';

    const DYNAMIC   = 'Couleur Dynamique';

    private int $red;
    private int $green;
    private int $blue;

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
            throw new InvalidArgumentException("Le tableau de couleur entré n'est pas correct.");
        }
        parent::__construct(self::DYNAMIC);
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
        return $this;
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
     * @inheritDoc
     */
    public function toCData()
    {
        // TODO: Implement toCData() method.
    }
}
