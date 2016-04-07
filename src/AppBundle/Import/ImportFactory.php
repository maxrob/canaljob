<?php


namespace AppBundle\Import;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class ImportFactory
{


    /**
     * Instanciate import system
     *
     * @param EntityManager $entityManager
     * @param FormFactory $formFactory
     * @return ImportInterface
     */
    public static function instanciate(Request $request, EntityManager $entityManager, FormFactory $formFactory)
    {
        $importSystem = null;
        $type = $request->get('type');


        switch ($type)
        {
            case 'CSV':
                $importSystem = new ImportCSV($entityManager, $formFactory);
                break;
            case 'XML':
                $importSystem = new ImportXML($entityManager, $formFactory);
                break;
            default:
                throw new \InvalidArgumentException("$type is not defined as import service.");
                break;
        }

        return $importSystem;
    }
}