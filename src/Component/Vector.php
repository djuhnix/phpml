<?php


namespace PHPML\Component;

use FFI\CData;
use InvalidArgumentException;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CSFMLType;
use PHPML\Exception\CDataException;
use PHPML\Library\GraphicsLibLoader as Lib;

class Vector
{
    use MyCData;

    private array $table;
    private CSFMLType $type;

    /**
     * Vector constructor.
     *
     * @param int $size
     * @param CSFMLType $type
     * @param array $table
     */
    public function __construct(CSFMLType $type, array $table = [0, 0], int $size = 2)
    {
        if ($type->getValue() != CSFMLType::VECTOR_2I
            && $type->getValue() != CSFMLType::VECTOR_2F
            && $type->getValue() != CSFMLType::VECTOR_2U) {
            throw new InvalidArgumentException("Invalide type CSFML reçu {$type->getKey()}, attendu VECTOR_*");
        }
        if ($size > 2) {
            throw new InvalidArgumentException("Les Vecteurs de taille supérieure à 2 ne sont pas pris en charge, reçu : {$size}");
        }
        $tableSize = count($table);
        if ($tableSize != $size) {
            throw new InvalidArgumentException("Le tableau passé en paramètre n'a pas la même taille que celle donné : {$tableSize} au lieu de $size");
        }
        $this->table = $table;
        $this->type = $type;
    }

    /**
     * @return CSFMLType
     */
    public function getType(): CSFMLType
    {
        return $this->type;
    }

    /**
     * Accesseur à un valeur du tableau
     *
     * @param int $index indice de la valeur à retourner
     * @return float|int la valeur se trouvant à l'indice donné
     */
    public function get(int $index) : float
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->table[$index];
    }

    /**
     * Modification d'une valeur du tableau
     *
     * @param int $index l'indice de la valeur à modifier
     * @param float $value nouvelle valeur
     */
    public function set(int $index, float $value)
    {
        if ($this->isCDataLoad()) {
            if ($index == 0) {
                $this->cdata->x = $value;
            } else {
                $this->cdata->y = $value;
            }
        }
        $this->table[$index] = $value;
    }

    /**
     * Accesseur au tableau de valeur.
     *
     * @return array
     */
    public function getArray(): array
    {
        if ($this->isCDataLoad()) {
            $this->updateFromCData();
        }
        return $this->table;
    }

    /**
     * @param array $table
     */
    public function setTable(array $table): void
    {
        $tableSize = count($table);
        $actualSize = count($this->table);
        if ($tableSize != $actualSize) {
            throw new InvalidArgumentException("Le tableau passé en paramètre n'a pas la même taille que le tableau actuel : $tableSize au lieu de $actualSize");
        }
        $this->table = $table;
        $this->toCData();
    }

    /**
     * @inheritDoc
     */
    protected function updateFromCData(): void
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("Les données C de Vecteur doivent être chargées pour mettre à jour les donnée de la classe.");
        }
        $this->table[0] = $this->cdata->x;
        $this->table[1] = $this->cdata->y;
    }

    /**
     * @inheritDoc
     */
    public function toCData(): CData
    {
        $this->cdata ??= Lib::getGraphicsLib()->new(
            Lib::getGraphicsLib()->type($this->type)
        );

        $this->cdata->x = $this->table[0];
        $this->cdata->y = $this->table[1];

        return $this->cdata;
    }
}
