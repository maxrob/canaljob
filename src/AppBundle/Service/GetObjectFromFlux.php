<?php

namespace AppBundle\Service;

use AppBundle\Entity\Formation;
use AppBundle\Entity\FormationPeriod;
use AppBundle\Entity\Job;
use Doctrine\ORM\EntityManager;
use parseCSV;
use SimpleXMLElement;
use Symfony\Component\Validator\Constraints\DateTime;

class GetObjectFromFlux
{
    public function __construct(EntityManager $em, $formFactory)
    {
        $this->em = $em;
        $this->department = $this->em->getRepository('AppBundle:Department');
        $this->company = $this->em->getRepository('AppBundle:Company');
        $this->flux_job_field = $this->em->getRepository('AppBundle:FluxJobField');
        $this->job_field = $this->em->getRepository('AppBundle:JobField');
        $this->flux_job_type = $this->em->getRepository('AppBundle:FluxJobType');
        $this->job_type = $this->em->getRepository('AppBundle:JobType');
        $this->formFactory = $formFactory;
    }

    public function getFluxXml($begin, $end)
    {

        $companies = $this->company->findAll();

        foreach ($companies as $company) {
            $flux = $company->getFluxXml();

            // get array of offer from flux xml
            $offers = simplexml_load_file($flux);

            // foreach all offer
            foreach ($offers as $offer) {

                // Create Datetime object of the offer's datecreation
                $creationDate = new \DateTime($offer->DATECREATION);

                $address = $offer->ADDRESSE;

                // if Datecreation is between begin and end
                if ($creationDate >= $begin && $creationDate <= $end) {
                    $begin_date = ($offer->DATEDEBUT) ? new \DateTime($offer->DATEDEBUT) : null;
                    $end_date = ($offer->DATEFIN) ? new \DateTime($offer->DATEFIN) : null;

                    $flux_job = [
                        'title'         => (string)$offer->INTITULE,
                        'description'   => (string)$offer->PRESENTATION,
                        'prerequisite'  => (string)$offer->PROFILCANDIDAT,
                        'beginDate'     => $begin_date,
                        'endDate'       => $end_date,
                        'url'           => (string)$offer->URL,
                        'mail'          => (string)$offer->MAIL_ENVOI_CV,
                        'isGeoloc'      => true,
                        'salaryMin'     => (int)$offer->REMUNERATION_MIN,
                        'salaryMax'     => (int)$offer->REMUNERATION_MAX,
                        'salaryType'    => (string)$offer->REMUNERATION_F,
                        'status'        => 0,
                        'company'       => $company
                    ];

                    $job = new Job();

                    $job->setTitle((string)$offer->INTITULE);
                    $job->setDescription((string)$offer->PRESENTATION);
                    $job->setPrerequisite((string)$offer->PROFILCANDIDAT);
                    $job->setBeginDate($begin_date);
                    $job->setEndDate($end_date);
                    $job->setUrl((string)$offer->URL);
                    $job->setMail((string)$offer->MAIL_ENVOI_CV);
                    $job->setIsGeoloc(true);
                    $job->setSalaryMin((int)$offer->REMUNERATION_MIN);
                    $job->setSalaryMax((int)$offer->REMUNERATION_MAX);
                    $job->setSalaryType((string)$offer->REMUNERATION_F);
                    $job->setStatus(0);
                    $job->setCompany($company);

                    $job_field = $this->job_field->findOneByName((string)$offer->FONCTION);

                    if($job_field) {
                        $job->setJobField($job_field);
                        $flux_job['jobField'] = $job_field;
                    } else {
                        $flux_job_field = $this->flux_job_field->findOneOrCreate(['name' => (string)$offer->FONCTION]);
                        $job->setFluxJobField($flux_job_field);
                        $flux_job['fluxJobField'] = $flux_job_field;
                    }

                    $job_type = $this->job_type->findOneByName((string)$offer->TYPECONTRAT);

                    if($job_type) {
                        $job->setJobType($job_type);
                        $flux_job['jobType'] = $job_type;
                    } else {
                        $flux_job_type = $this->flux_job_type->findOneOrCreate(['name' => (string)$offer->TYPECONTRAT]);
                        $job->setFluxJobType($flux_job_type);
                        $flux_job['fluxJobType'] = $flux_job_type;
                    }

                    // Geolocation
                    $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
                    $geo = json_decode($geo, true);
                    if ($geo['status'] === 'OK') {
                        $job->setAddress($geo['results'][0]['formatted_address']);
                        $job->setLatitude($geo['results'][0]['geometry']['location']['lat']);
                        $job->setLongitude($geo['results'][0]['geometry']['location']['lng']);

                        $flux_job['address'] = $geo['results'][0]['formatted_address'];
                        $flux_job['latitude'] = $geo['results'][0]['geometry']['location']['lat'];
                        $flux_job['longitude'] = $geo['results'][0]['geometry']['location']['lng'];


                        foreach ($geo['results'][0]['address_components'] as $component) {
                            switch ($component['types'][0]) {
                                case 'locality':
                                    $job->setCity($component['long_name']);
                                    $flux_job['city'] = $component['long_name'];
                                    break;
                                case 'postal_code':
                                    $job->setZip($component['long_name']);
                                    $flux_job['zip'] = $component['long_name'];
                                    break;
                                case 'administrative_area_level_2':
                                    $department = $this->department->findOneByName(strtoupper($component['long_name']));
                                    if ($department) {
                                        $job->setDepartment($department);
                                        $flux_job['department'] = $department;
                                    }
                                    break;
                            }
                        }
                    }

                    $flux_job_form = $this->formFactory->create('appbundle_job', $job);

                    if(!$flux_job_form->isValid()) {
                        foreach ($flux_job_form->getErrors() as $key => $error) {
                            var_dump($key, $error);
                        }
                        var_dump('error');
                    } else {
                        var_dump('toto');
                    }

                    //$this->em->persist($job);
                    //$this->em->flush();

                }
            }
        }
        die($job);
    }

    public function getFluxCSV($file, $school) {

        // Your csv file here when you hit submit button
        $csv = new parseCSV();
        $csv->auto($file->getData());

        foreach($csv->data as $data) {
            $formation = new Formation();
            $formation->setTitle($data['titre']);
            $formation->setDescription($data['description']);
            $formation->setPerspective($data['perspective']);
            $formation->setUrl($data['url']);
            $formation->setMail($data['mail']);
            $formation->setSchool($school);
            $formation->setIsGeoloc(true);
            $formation->setStatus(0);

            $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($data['adresse']).'&sensor=false');
            $geo = json_decode($geo, true);
            if ($geo['status'] === 'OK') {
                $formation->setAddress($geo['results'][0]['formatted_address']);
                $formation->setLatitude($geo['results'][0]['geometry']['location']['lat']);
                $formation->setLongitude($geo['results'][0]['geometry']['location']['lng']);

                foreach($geo['results'][0]['address_components'] as $component) {
                    switch ($component['types'][0]) {
                        case 'locality':
                            $formation->setCity($component['long_name']);
                            break;
                        case 'postal_code':
                            $formation->setZip($component['long_name']);
                            break;
                        case 'administrative_area_level_2':
                            $department = $this->department->findOneByName(strtoupper($component['long_name']));
                            if($department) {
                                $formation->setDepartment($department);
                            }
                            break;
                    }
                }
            }

            $this->em->persist($formation);
            $this->em->flush();

            $begin_date = explode(', ', $data['date_debut']);
            $end_date = explode(', ', $data['date_fin']);

            for($i = 0; $i < count($begin_date); $i++) {
                $begin = new \DateTime($begin_date[$i]);
                $end = new \DateTime($end_date[$i]);

                $period = new FormationPeriod();
                $period->setBeginDate($begin);
                $period->setEndDate($end);
                $period->setFormation($formation);

                $this->em->persist($period);
                $this->em->flush();
            }
        }
    }
}