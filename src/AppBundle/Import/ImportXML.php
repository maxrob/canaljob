<?php


namespace AppBundle\Import;


use AppBundle\Entity\Job;
use AppBundle\Service\EntityManager;
use AppBundle\Service\FormFactory;

class ImportXML implements ImportInterface
{
    /**
     * @var
     */
    private $parameters;

    /**
     * @var
     */
    private $object;

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
        $this->em = EntityManager::get();
        $this->department = $this->em->getRepository('AppBundle:Department');
        $this->company = $this->em->getRepository('AppBundle:Company');
        $this->flux_job_field = $this->em->getRepository('AppBundle:FluxJobField');
        $this->job_field = $this->em->getRepository('AppBundle:JobField');
        $this->flux_job_type = $this->em->getRepository('AppBundle:FluxJobType');
        $this->job_type = $this->em->getRepository('AppBundle:JobType');
        $this->formFactory = FormFactory::get();
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

                var_dump($this->object);
            }
        }

        die;



        //$flux_job_form = $this->formFactory->create('appbundle_job', $this->object);

        /* if(!$flux_job_form->isValid()) {
            foreach ($flux_job_form->getErrors() as $key => $error) {
                var_dump($key, $error);
            }
            var_dump('error');
        } else {
            var_dump('toto');
        } */

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

            $this->object->setTitle((string)$data->INTITULE);
            $this->object->setDescription((string)$data->PRESENTATION);
            $this->object->setPrerequisite((string)$data->PROFILCANDIDAT);
            $this->object->setBeginDate($begin_date);
            $this->object->setEndDate($end_date);
            $this->object->setUrl((string)$data->URL);
            $this->object->setMail((string)$data->MAIL_ENVOI_CV);
            $this->object->setIsGeoloc(true);
            $this->object->setSalaryMin((int)$data->REMUNERATION_MIN);
            $this->object->setSalaryMax((int)$data->REMUNERATION_MAX);
            $this->object->setSalaryType((string)$data->REMUNERATION_F);
            $this->object->setStatus(0);

            $this->getAddressData($data->ADRESSE);
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
            $flux_job['jobField'] = $job_field;
        } else {
            $flux_job_field = $this->flux_job_field->findOneOrCreate(['name' => $domain]);
            $this->object->setFluxJobField($flux_job_field);
            $flux_job['fluxJobField'] = $flux_job_field;
        }

        $job_type = $this->job_type->findOneByName($type);

        if($job_type) {
            $this->object->setJobType($job_type);
            $flux_job['jobType'] = $job_type;
        } else {
            $flux_job_type = $this->flux_job_type->findOneOrCreate(['name' => $type]);
            $this->object->setFluxJobType($flux_job_type);
            $flux_job['fluxJobType'] = $flux_job_type;
        }
    }


}