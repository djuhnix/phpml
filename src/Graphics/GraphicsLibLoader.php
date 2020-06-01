<?php


namespace PHPML\Graphics;

use FFI\Exception;
use PHPML\AbstractFFI;
use PHPML\Exception\FFILoadingException;

trait GraphicsLibLoader
{
    use AbstractFFI;

    /**
     * Vérifie si une bibliothèque est chargé, si ce n'est pas le cas la méthode initie le chargement de la bibliothèque
     * déjà préchargé par PHP dans le scope GRAPHICS.
     *
     * @throws FFILoadingException si la bibliothèque n'a pas pu être chargé.
     */
    protected function checkLibAndLoad() : void
    {
        try {
            if (!$this->isLibLoad()) {
                $this->initLib('preload', 'GRAPHICS');
            }
        } catch (Exception $exception) {
            throw new FFILoadingException($exception->getMessage());
        }
    }
}
