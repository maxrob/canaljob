<?php


namespace AppBundle\Import;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;

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

    public function __construct(EntityManager $entityManager, FormFactory $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    public function getSource()
    {
        // TODO: Implement getSource() method.
    }

    public function import()
    {
        var_dump("implements import for csv");
    }

    public function setParameters($parameters)
    {
        // TODO: Implement setParameters() method.
    }
}