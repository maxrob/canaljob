<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\School;
use AppBundle\Import\ImportFactory;
use AppBundle\Import\ImportCSV;
use AppBundle\Import\FluxInterface;
use AppBundle\Import\ImportInterface;
use AppBundle\Import\ImportXML;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

        $form = $this->createForm('appbundle_get_csv');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Get file
            $file = $form->get('csv_file');
            $school = $form->get('schools')->getData();

            $fluxService = $this->get('get_object_from_flux');

            $fluxService->getFluxCSV($file, $school);
        }

        return $this->render(':default:csv.html.twig',
            ['form' => $form->createView()]
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
        $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
        $geo = json_decode($geo, true);
        if ($geo['status'] === 'OK')
        {
            $company->setAddress($geo['results'][0]['formatted_address']);
            $company->setLatitude($geo['results'][0]['geometry']['location']['lat']);
            $company->setLongitude($geo['results'][0]['geometry']['location']['lng']);

            foreach ($geo['results'][0]['address_components'] as $component)
            {
                switch ($component['types'][0])
                {
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
        $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
        $geo = json_decode($geo, true);
        if ($geo['status'] === 'OK')
        {
            $school->setAddress($geo['results'][0]['formatted_address']);
            $school->setLatitude($geo['results'][0]['geometry']['location']['lat']);
            $school->setLongitude($geo['results'][0]['geometry']['location']['lng']);

            foreach ($geo['results'][0]['address_components'] as $component)
            {
                switch ($component['types'][0])
                {
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

    /**
     * /admin/import/{type}
     * /admin/import/xml
     * /admin/import/csv
     *
     * @param Request $request
     */
    public function importAction(Request $request)
    {
        $parameters = [];

        /** @var ImportInterface $import */
        $importService = ImportFactory::instanciate('xml', $parameters);

        $importService->import();
    }
}
