<?php

namespace AppBundle\Service;

use AppBundle\Entity\Job;
use Doctrine\ORM\EntityManager;
use SimpleXMLElement;
use Symfony\Component\Validator\Constraints\DateTime;

class GetObjectFromFlux
{
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->department = $this->em->getRepository('AppBundle:Department');
        $this->company = $this->em->getRepository('AppBundle:Company');
        $this->flux_job_field = $this->em->getRepository('AppBundle:FluxJobField');
        $this->flux_job_type = $this->em->getRepository('AppBundle:FluxJobType');
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

                    $flux_job_field = $this->flux_job_field->findOneOrCreate(['name' => (string)$offer->FONCTION]);
                    $job->setFluxJobField($flux_job_field);

                    $flux_job_type = $this->flux_job_type->findOneOrCreate(['name' => (string)$offer->TYPECONTRAT]);
                    $job->setFluxJobType($flux_job_type);

                    // Geolocation
                    $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
                    $geo = json_decode($geo, true);
                    if ($geo['status'] === 'OK') {
                        $job->setAddress($geo['results'][0]['formatted_address']);
                        $job->setLatitude($geo['results'][0]['geometry']['location']['lat']);
                        $job->setLongitude($geo['results'][0]['geometry']['location']['lng']);

                        foreach ($geo['results'][0]['address_components'] as $component) {
                            switch ($component['types'][0]) {
                                case 'locality':
                                    $job->setCity($component['long_name']);
                                    break;
                                case 'postal_code':
                                    $job->setZip($component['long_name']);
                                    break;
                                case 'administrative_area_level_2':
                                    $department = $this->department->findOneByName(strtoupper($component['long_name']));
                                    if ($department) {
                                        $job->setDepartment($department);
                                    }
                                    break;
                            }
                        }
                    }

                    $this->em->persist($job);
                    $this->em->flush();

                }
            }
        }
        die($job);
    }

    public function getFluxCSV($begin, $end) {

        $companies = $this->company->findAll();

        foreach($companies as $company) {
            $flux = $company->getFluxXml();

            // get array of offer from flux xml
            $offers = simplexml_load_file($flux);

            // foreach all offer
            foreach($offers as $offer) {

                // Create Datetime object of the offer's datecreation
                $creationDate = new \DateTime($offer->DATECREATION);

                $address = $offer->ADDRESSE;

                // if Datecreation is between begin and end
                if($creationDate >= $begin && $creationDate <= $end)
                {
                    $begin_date = ($offer->DATEDEBUT) ? new \DateTime($offer->DATEDEBUT) : null;
                    $end_date = ($offer->DATEFIN) ? new \DateTime($offer->DATEFIN) : null;

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

                    $flux_job_field = $this->flux_job_field->findOneOrCreate(['name' => (string)$offer->FONCTION]);
                    $job->setFluxJobField($flux_job_field);

                    $flux_job_type = $this->flux_job_type->findOneOrCreate(['name' => (string)$offer->TYPECONTRAT]);
                    $job->setFluxJobType($flux_job_type);

                    // Geolocation
                    $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
                    $geo = json_decode($geo, true);
                    if ($geo['status'] === 'OK') {
                        $job->setAddress($geo['results'][0]['formatted_address']);
                        $job->setLatitude($geo['results'][0]['geometry']['location']['lat']);
                        $job->setLongitude($geo['results'][0]['geometry']['location']['lng']);

                        foreach($geo['results'][0]['address_components'] as $component) {
                            switch ($component['types'][0]) {
                                case 'locality':
                                    $job->setCity($component['long_name']);
                                    break;
                                case 'postal_code':
                                    $job->setZip($component['long_name']);
                                    break;
                                case 'administrative_area_level_2':
                                    $department = $this->department->findOneByName(strtoupper($component['long_name']));
                                    if($department) {
                                        $job->setDepartment($department);
                                    }
                                    break;
                            }
                        }
                    }

                    $this->em->persist($job);
                    $this->em->flush();

                }
            }
        }
    }
}