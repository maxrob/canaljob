<?php

namespace AppBundle\Service;

use AppBundle\Entity\Job;
use Symfony\Component\Validator\Constraints\DateTime;

class GetObjectFromFlux
{

    public function getFluxXml($flux, $begin, $end)
    {

        // get array of offer from flux xml
        $offers = simplexml_load_file($flux);

        // foreach all offer
        foreach($offers as $offer) {

            // Create Datetime object of the offer's datecreation
            $creationDate = new \DateTime($offer->DATECREATION);

            // if Datecreation is between begin and end
            if($creationDate >= $begin && $creationDate <= $end)
            {
                $array_offer = (array) $offer;
                var_dump($offer);
                $jobXml = [
                    'title'         => $offer->INTITULE,
                    'description'   => $offer->PRESENTATION,
                    'prerequisite'  => $offer->PROFILCANDIDAT,
                    'begin_date'    => $offer->DATEDEBUT,
                    'end_date'      => $offer->DATEFIN,
                    'url'           => $offer->URL,
                    'mail'          => $offer->MAIL_ENVOI_CV,
                    'is_geoloc'     => true,
                    'salary_min'    => $array_offer['REMUNERATION-1'],
                    'salary_max'    => $array_offer['REMUNERATION-2'],
                    'salary_type'   => $array_offer['REMUNERATION-F'],
                    'status'        => 0
                ];
                new Job();





            }

        }

        die();
    }
}