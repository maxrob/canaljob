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

    public function __construct($parameters, EntityManager $em, FormFactory $formFactory)
    {
        $this->em = $em;
        $this->department = $this->em->getRepository('AppBundle:Department');
        $this->company = $this->em->getRepository('AppBundle:Company');
        $this->flux_job_field = $this->em->getRepository('AppBundle:FluxJobField');
        $this->job_field = $this->em->getRepository('AppBundle:JobField');
        $this->flux_job_type = $this->em->getRepository('AppBundle:FluxJobType');
        $this->job_type = $this->em->getRepository('AppBundle:JobType');
        $this->formFactory = $formFactory;
        $this->parameters = $parameters;
    }

    public function import()
    {

    }

    public function getSource($url)
    {
        // TODO: Implement getSource() method.
    }

    public function constructObject($data)
    {
        // TODO: Implement getObject() method.
    }

    public function getAddressData($address)
    {
        // TODO: Implement getAddresses() method.
    }

    public function getCorrespondence($domain , $type)
    {
        // TODO: Implement getCorrespondence() method.
    }
}