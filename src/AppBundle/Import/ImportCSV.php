<?php


namespace AppBundle\Import;


use AppBundle\Entity\Formation;
use AppBundle\Entity\FormationPeriod;
use Doctrine\ORM\EntityManager;
use parseCSV;
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
    private $em;

    /**
     * @var
     */
    private $object;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var RecursiveValidator
     */
    private $validator;

    /**
     * @var array
     */
    private $errors = [];

    public function __construct(EntityManager $entityManager, FormFactory $formFactory, RecursiveValidator $validator)
    {
        $this->em = $entityManager;
        $this->formFactory = $formFactory;
        $this->validator = $validator;

        $this->department = $this->em->getRepository('AppBundle:Department');
        $this->school = $this->em->getRepository('AppBundle:School');
        $this->flux_formation_field = $this->em->getRepository('AppBundle:FluxFormationField');
        $this->formation_field = $this->em->getRepository('AppBundle:FormationField');
        $this->flux_formation_type = $this->em->getRepository('AppBundle:FluxFormationType');
        $this->formation_type = $this->em->getRepository('AppBundle:FormationType');
    }

    public function import()
    {

        $data = $this->getSource($this->parameters['file']);
        foreach($data as $offer) {

            $this->object = new Formation();
            $this->object->setSchool($this->parameters['school']);
            $this->constructObject($offer);
            $this->validateAndSubmitObject();
            $this->getDate($offer);

        }

        return $this->errors;

    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getSource($url)
    {
        $csv = new parseCSV();
        $csv->auto($url->getData());

        return $csv->data;
    }


    public function constructObject($data)
    {
        $this->object->setTitle($data['titre']);
        $this->object->setDescription($data['description']);
        $this->object->setPerspective($data['perspective']);
        $this->object->setUrl($data['url']);
        $this->object->setMail($data['mail']);
        $this->object->setIsGeoloc(true);
        $this->object->setStatus(0);

        $this->getAddressData($data['adresse']);
        $this->getCorrespondence((string)$data['domaine_formation'], (string)$data['type_contrat']);
    }

    public function getAddressData($address)
    {
        $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
        $geo = json_decode($geo, true);
        if ($geo['status'] === 'OK') {
            $this->object->setAddress($geo['results'][0]['formatted_address']);
            $this->object->setLatitude($geo['results'][0]['geometry']['location']['lat']);
            $this->object->setLongitude($geo['results'][0]['geometry']['location']['lng']);

            foreach($geo['results'][0]['address_components'] as $component) {
                switch ($component['types'][0]) {
                    case 'locality':
                        $this->object->setCity($component['long_name']);
                        break;
                    case 'postal_code':
                        $this->object->setZip($component['long_name']);
                        break;
                    case 'administrative_area_level_2':
                        $department = $this->department->findOneByName(strtoupper($component['long_name']));
                        if($department) {
                            $this->object->setDepartment($department);
                        }
                        break;
                }
            }
        }
    }

    public function getCorrespondence($domain, $type)
    {
        $formation_field = $this->formation_field->findOneByName($domain);

        if($formation_field) {
            $this->object->setFormationField($formation_field);
        } else {
            $flux_formation_field = $this->flux_formation_field->findOneOrCreate(['name' => (string)$domain]);
            $this->object->setFluxFormationField($flux_formation_field);
        }

        $formation_type = $this->formation_type->findOneByName($type);

        if($formation_type) {
            $this->object->setFormationType($formation_type);
        } else {
            $flux_formation_type = $this->flux_formation_type->findOneOrCreate(['name' => $type]);
            $this->object->setFluxFormationType($flux_formation_type);
        }
    }

    public function getDate($data) {
        $begin_date = explode(', ', $data['date_debut']);
        $end_date = explode(', ', $data['date_fin']);

        for($i = 0; $i < count($begin_date); $i++) {
            $begin = new \DateTime($begin_date[$i]);
            $end = new \DateTime($end_date[$i]);

            $period = new FormationPeriod();
            $period->setBeginDate($begin);
            $period->setEndDate($end);
            $period->setFormation($this->object);

            $this->em->persist($period);
            $this->em->flush();
        }
    }

    public function validateAndSubmitObject()
    {
        $errors = $this->validator->validate($this->object);
        $error_message = [];

        if(count($errors) > 0) {
            foreach($errors as $error) {
                $error_message[$error->getPropertyPath()] = $error->getMessage();
            }

            $error_object = [
                "object" => $this->object,
                "errors" => $error_message
            ];

            $this->errors[] = $error_object;
        } else {
            $this->em->persist($this->object);
            $this->em->flush();
        }
    }
}