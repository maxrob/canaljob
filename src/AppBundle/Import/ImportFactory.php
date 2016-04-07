<?php


namespace AppBundle\Import;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImportFactory
{
    /**
     * Instanciate import system
     *
     * @param Request $request
     * @param EntityManager $entityManager
     * @param FormFactory $formFactory
     * @param RecursiveValidator|ValidatorInterface $validator
     * @return ImportInterface
     */
    public static function instanciate(Request $request, EntityManager $entityManager, FormFactory $formFactory, RecursiveValidator $validator)
    {
        $importSystem = null;
        $type = $request->get('type');

        switch ($type)
        {
            case 'CSV':
                $importSystem = new ImportCSV($entityManager, $formFactory, $validator);
                break;
            case 'XML':
                $importSystem = new ImportXML($entityManager, $formFactory, $validator);
                break;
            default:
                throw new \InvalidArgumentException("$type is not defined as import service.");
                break;
        }

        return $importSystem;
    }
}