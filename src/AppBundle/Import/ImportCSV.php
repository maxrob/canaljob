<?php


namespace AppBundle\Import;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class ImportCSV implements ImportInterface
{
    /**
     * @var
     */
    private $parameters;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var RecursiveValidator
     */
    private $validator;

    public function __construct(EntityManager $entityManager, FormFactory $formFactory, RecursiveValidator $validator)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->validator = $validator;
    }

    public function import()
    {
        var_dump($this->validator);
        var_dump("implements import for csv");
    }

    public function setParameters($parameters)
    {
        // TODO: Implement setParameters() method.
    }

    public function getSource($url)
    {
        // TODO: Implement getSource() method.
    }


    public function getAddress($address)
    {
        // TODO: Implement getAddress() method.
    }

    public function getCorrespondence($domain, $type)
    {
        // TODO: Implement getCorrespondence() method.
    }

    public function validateObject()
    {
        // TODO: Implement getCorrespondence() method.
    }

    public function getAddressData($address)
    {
        // TODO: Implement getAddressData() method.
    }
}