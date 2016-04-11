<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SeedController extends BaseController
{
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
}
