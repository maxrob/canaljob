<?php


namespace AppBundle\Import;


use AppBundle\Entity\Job;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class ImportXML implements ImportInterface
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
     * @var
     */
    private $object;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var RecursiveValidator
     */
    private $validator;

    public function __construct(EntityManager $entityManager, FormFactory $formFactory, RecursiveValidator $validator)
    {
        $this->department = $this->em->getRepository('AppBundle:Department');
        $this->company = $this->em->getRepository('AppBundle:Company');
        $this->flux_job_field = $this->em->getRepository('AppBundle:FluxJobField');
        $this->job_field = $this->em->getRepository('AppBundle:JobField');
        $this->flux_job_type = $this->em->getRepository('AppBundle:FluxJobType');
        $this->job_type = $this->em->getRepository('AppBundle:JobType');
        $this->formFactory = $formFactory;

        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    public function import()
    {
        $companies = $this->company->findAll();

        foreach ($companies as $company) {
            $url = $company->getFluxXml();

            $data = $this->getSource($url);

            foreach($data as $offer) {
                $this->object = new Job();

                $this->object->setCompany($company);
                $this->constructObject($offer);

                $this->errors[] = $this->validateObject();
            }
        }

        die;
        //$this->em->persist($job);
        //$this->em->flush();
    }

    public function getSource($url)
    {
       return simplexml_load_file($url);
    }

    public function constructObject($data)
    {
        $creationDate = new \DateTime($data->DATECREATION);

        if ($creationDate >= $this->parameters["begin"] && $creationDate <= $this->parameters["end"]) {
            $begin_date = ($data->DATEDEBUT) ? new \DateTime($data->DATEDEBUT) : null;
            $end_date = ($data->DATEFIN) ? new \DateTime($data->DATEFIN) : null;


            $this->object->setSalaryMin((int)$data->REMUNERATION_MIN);
            $this->object->setSalaryMax((int)$data->REMUNERATION_MAX);
            $this->object->setSalaryType((string)$data->REMUNERATION_F);
            $this->object->setStatus(0);

            $this->getAddressData((string) $data->ADRESSE);
            $this->getCorrespondence((string)$data->FONCTION, (string)$data->TYPECONTRAT);

        }
    }

    public function getAddressData($address)
    {
        $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
        $geo = json_decode($geo, true);
        if ($geo['status'] === 'OK') {
            $this->object->setAddress($geo['results'][0]['formatted_address']);
            $this->object->setLatitude($geo['results'][0]['geometry']['location']['lat']);
            $this->object->setLongitude($geo['results'][0]['geometry']['location']['lng']);

            foreach ($geo['results'][0]['address_components'] as $component) {
                switch ($component['types'][0]) {
                    case 'locality':
                        $this->object->setCity($component['long_name']);
                        break;

                    case 'postal_code':
                        $this->object->setZip($component['long_name']);
                        break;

                    case 'administrative_area_level_2':
                        $department = $this->department->findOneByName(strtoupper($component['long_name']));
                        if ($department) {
                            $this->object->setDepartment($department);
                        }
                        break;
                }
            }
        }
    }

    public function getCorrespondence($domain , $type)
    {
        $job_field = $this->job_field->findOneByName($domain);

        if($job_field) {
            $this->object->setJobField($job_field);
        } else {
            $flux_job_field = $this->flux_job_field->findOneOrCreate(['name' => $domain]);
            $this->object->setFluxJobField($flux_job_field);
        }
        $job_type = $this->job_type->findOneByName($type);

        if($job_type) {
            $this->object->setJobType($job_type);
        } else {
            $flux_job_type = $this->flux_job_type->findOneOrCreate(['name' => $type]);
            $this->object->setFluxJobType($flux_job_type);
        }
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function validateObject()
    {
        var_dump($this->object);
        $errors = $this->validator->validate($this->object);
        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;

            var_dump($errorsString);

        }
        die;
    }
}