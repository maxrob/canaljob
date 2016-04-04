<?php


namespace AppBundle\Import;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class ImportFactory
{


    /**
     * Instanciate import system
     *
     * @param Request $request
     * @param EntityManager $entityManager
     * @param FormFactory $formFactory
     * @return ImportInterface
     */
    public static function instanciate(EntityManager $entityManager, FormFactory $formFactory)
    {
        $importSystem = null;
        $type = 'XML'; //$request->get('type');
        $parameters = []; //$request->get('parameters');

        switch ($type)
        {
            case 'CSV':
                $importSystem = new ImportCSV($entityManager, $formFactory, $parameters);
                break;
            case 'XML':
                $importSystem = new ImportXML($entityManager, $formFactory, $parameters);
                break;
            default:
                throw new \InvalidArgumentException("$type is not defined as import service.");
                break;
        }

        return $importSystem;
    }
}