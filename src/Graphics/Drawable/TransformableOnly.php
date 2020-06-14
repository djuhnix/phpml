<?php


namespace PHPML\Graphics\Drawable;


use PHPML\Enum\Color;

/**
 * Trait TransformableOnly
 * Utilisé pour redéfinir les méthodes de base qui permettent d'accéder ou de modifier
 * certaines données d'un objet modifiable, pour ne laisser que celles
 * qui permettent la transformation de l'objet
 *
 * @package PHPML\Graphics\Drawable
 */
trait TransformableOnly
{
    /**
     * Retourne constamment null, cet élément n'a pas de couleur de remplissage
     *
     * @return Color|null
     */
    public function getFillColor(): ?Color
    {
        return null;
    }

    /**
     * Cette méthode ne fait rien, cet élément n'a pas de couleur de remplissage
     *
     * @param Color $fillColor
     */
    public function setFillColor(Color $fillColor = null): void
    {
        return;
    }

    /**
     * Retourne toujours null, cet élément n'a pas de couleur de contours
     *
     * @return Color|null
     */
    public function getOutlineColor(): ?Color
    {
        return null;
    }

    /**
     * Cette méthode ne fait rien, cet élément n'a pas de couleur de contours.
     *
     * @param Color $outlineColor
     */
    public function setOutlineColor(Color $outlineColor): void
    {
        return;
    }

    /**
     * Retourne toujours null, cet élément n'a pas de contour
     *
     * @return float|null
     */
    public function getOutlineThickness(): ?float
    {
        return null;
    }

    /**
     * Cette méthode ne fait rien, cet élément n'a pas de contour
     *
     * @param float $outlineThickness
     */
    public function setOutlineThickness(float $outlineThickness): void
    {
        return;
    }
}