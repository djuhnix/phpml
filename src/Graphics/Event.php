<?php

namespace PHPML\Graphics;

use FFI;
use PHPML\AbstractFFI\MyCData;
use PHPML\Enum\CSFMLType;
use PHPML\Enum\EventType;
use PHPML\Event\TriggerEvent;
use PHPML\Exception\CDataException;
use PHPML\Graphics\GraphicsLibLoader as Lib;

class Event
{
    use MyCData;

    private ?TriggerEvent $actualEvent = null;

    /**
     * Accesseur au type de l'événement contenu dans la donnée C.
     *
     * @return EventType
     */
    public function getType(): EventType
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de l'événement n'est pas chargé pour pouvoir avoir le type d'événement.");
        }

        return  new EventType($this->cdata->type);
    }

    /**
     * L'événement actuellement déclenché sur la fenêtre.
     * @return TriggerEvent|null l'événement actuellement déclenché
     */
    public function getActualEvent(): ?TriggerEvent
    {
        if (!$this->isCDataLoad()) {
            throw new CDataException("La donnée C de l'événement n'est pas chargé pour pouvoir obtenir l'événement actuelle.");
        }

        $count = 0;
        foreach (EventType::TRIGGERABLE as $key => $item) {
            $typeIsDefined = null;
            try {
                $typeIsDefined = !FFI::isNull($this->cdata->{$key});

            } catch (FFI\Exception $exception) {
                $count += 1;
                $typeIsDefined = false;
            }
            //$res = $typeIsDefined ? 'true' : 'false';
            //echo 'type is defined n°' . $count .' '. $res  . "\n";
            if ($typeIsDefined) {
                $class = 'PHPML\\Event\\' . substr($item, 2);
                //echo 'Classe : ' . $class;
                $this->actualEvent = new $class($this);
            }
        }

        return $this->actualEvent;
    }

    /**
     * Convertit l'événement en donnée C.
     * Si l'événement a déjà été convertit précédemment il est retourné.
     *
     * @throws \InvalidArgumentException si l'événement n'a pas pour valeur LIB_MANAGED
     */
    public function toCData(): FFI\CData
    {
        $this->cdata ??= Lib::getGraphicsLib()->new(
            Lib::getGraphicsLib()->type(CSFMLType::EVENT)
        );
        return $this->cdata;
    }
}
