<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\Formation;
use AppBundle\Entity\FormationPeriod;
use AppBundle\Entity\School;
use Doctrine\ORM\EntityManager;
use parseCSV;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SimpleXMLElement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use UserBundle\Entity\User;

class BaseController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render(':default:index.html.twig');
    }

    /**
     * @Route("/flux/xml")
     */
    public function fluxXmlAction()
    {
        $fluxService = $this->get('get_object_from_flux');

        $begin = new \DateTime("2016-03-15");
        $end = new \DateTime("2016-04-15");

        $fluxService->getFluxXml($begin, $end);

        return $this->render(':default:index.html.twig');
    }

    /**
     * @Route("/flux/csv")
     */
    public function fluxCSVAction(Request $request)
    {

        $form = $this->createFormBuilder()
            ->add('csv_file', 'file', array('label' => 'File to Submit'))
            ->add('schools', EntityType::class, array(
                'class' => 'AppBundle:School',
                'choice_label' => 'name',
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get file
            $file = $form->get('csv_file');
            $school = $form->get('schools')->getData();

            // Your csv file here when you hit submit button
            $csv = new parseCSV();
            $csv->auto($file->getData());

            $em = $this->getDoctrine()->getManager();

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

                    var_dump($geo['results'][0]['address_components']);

                    foreach($geo['results'][0]['address_components'] as $component) {
                        switch ($component['types'][0]) {
                            case 'locality':
                                $formation->setCity($component['long_name']);
                                break;
                            case 'postal_code':
                                $formation->setZip($component['long_name']);
                                break;
                            case 'administrative_area_level_2':
                                $department = $em->getRepository('AppBundle:Department')->findOneByName(strtoupper($component['long_name']));
                                if($department) {
                                    $formation->setDepartment($department);
                                }
                                break;
                        }
                    }
                }


                $em->persist($formation);
                $em->flush();

                $begin_date = explode(', ', $data['date_debut']);
                $end_date = explode(', ', $data['date_fin']);

                for($i = 0; $i < count($begin_date); $i++) {
                    $begin = new \DateTime($begin_date[$i]);
                    $end = new \DateTime($end_date[$i]);

                    $period = new FormationPeriod();
                    $period->setBeginDate($begin);
                    $period->setEndDate($end);
                    $period->setFormation($formation);

                    $em->persist($period);
                    $em->flush();
                }

                var_dump($formation);
            }
            die;
        }

        return $this->render(':default:csv.html.twig',
            array('form' => $form->createView(),)
        );
    }

    /**
     * @Route("/seed/company")
     */
    public function seedCompanyAction()
    {

        $user = new User();
        $user->setUsername('company@gmail.com');
        $user->setEmail('company@gmail.com');
        $user->setPassword('toto');
        $user->setLastname('Robin');
        $user->setFirstname('Maxime');
        $user->setEnabled(true);
        $user->setRoles(['ROLE_COMPANY']);
        $user->setPhone('0606060606');

        $company = new Company();
        $company->setName('Sogeti');
        $address = "27, bis rue du progrès, 93100 Montreuil";
        $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
        $geo = json_decode($geo, true);
        if ($geo['status'] === 'OK') {
            $company->setAddress($geo['results'][0]['formatted_address']);
            $company->setLatitude($geo['results'][0]['geometry']['location']['lat']);
            $company->setLongitude($geo['results'][0]['geometry']['location']['lng']);

            foreach($geo['results'][0]['address_components'] as $component) {
                switch ($component['types'][0]) {
                    case 'locality':
                        $company->setCity($component['long_name']);
                        break;
                }
            }
        }
        $company->setFluxXml("http://robinmaxime.com/flux.php");
        //"http://jobs.contactrh.com/get/XAePWe9fIg0G?client=sogeti"

        $em = $this->getDoctrine()->getManager();
        $em->persist($company);
        $em->flush();

        $user->setCompany($company);

        $em->persist($user);
        $em->flush();

        return $this->render(':default:index.html.twig');
    }

    /**
     * @Route("/seed/school")
     */
    public function seedSchoolAction()
    {

        $user = new User();
        $user->setUsername('school@gmail.com');
        $user->setEmail('school@gmail.com');
        $user->setPassword('toto');
        $user->setLastname('Robin');
        $user->setFirstname('Maxime');
        $user->setEnabled(true);
        $user->setRoles(['ROLE_SCHOOL']);
        $user->setPhone('0606060606');

        $school = new School();
        $school->setName('HETIC');
        $school->getIsOnlyOnline(false);
        $address = "27, bis rue du progrès, 93100 Montreuil";
        $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
        $geo = json_decode($geo, true);
        if ($geo['status'] === 'OK') {
            $school->setAddress($geo['results'][0]['formatted_address']);
            $school->setLatitude($geo['results'][0]['geometry']['location']['lat']);
            $school->setLongitude($geo['results'][0]['geometry']['location']['lng']);

            foreach($geo['results'][0]['address_components'] as $component) {
                switch ($component['types'][0]) {
                    case 'locality':
                        $school->setCity($component['long_name']);
                        break;
                }
            }
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($school);
        $em->flush();

        $user->setSchool($school);

        $em->persist($user);
        $em->flush();

        return $this->render(':default:index.html.twig');
    }
}
