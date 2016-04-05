<?php


namespace AppBundle\Import;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;

class ImportFactory
{


    /**
     * Instanciate import system
     *
     * @param EntityManager $entityManager
     * @param FormFactory $formFactory
     * @return ImportInterface
     */
    public static function instanciate(Request $request, EntityManager $entityManager, FormFactory $formFactory, Constraint $validation)
    {
        $importSystem = null;
        $type = $request->get('type');

        switch ($type)
        {
            case 'CSV':
                $importSystem = new ImportCSV($entityManager, $formFactory, $validation);
                break;
            case 'XML':
                $importSystem = new ImportXML($entityManager, $formFactory, $validation);
                break;
            default:
                throw new \InvalidArgumentException("$type is not defined as import service.");
                break;
        }

        return $importSystem;
    }
}