<?php


namespace AppBundle\Import;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ImportFactory
{


    /**
     * Instanciate import system
     *
     * @param $type
     * @param $parameters
     * @return ImportInterface
     */
    public static function instanciate($type, $parameters)
    {
        $importSystem = null;

        switch ($type)
        {
            case 'CSV':
                $importSystem = new ImportCSV($parameters);
                break;
            case 'XML':
                $importSystem = new ImportXML($parameters);
                break;
            default:
                throw new \InvalidArgumentException("$type is not defined as import service.");
                break;
        }

        return $importSystem;
    }
}