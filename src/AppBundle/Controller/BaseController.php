<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        $fluxService = $this->get('get_object_from_flux');

        $xml = "http://jobs.contactrh.com/get/XAePWe9fIg0G?client=sogeti";
        $begin = new \DateTime("2016-01-15");
        $end = new \DateTime("2016-02-15");

        $fluxService->getFluxXml($xml, $begin, $end);

        return $this->render(':default:index.html.twig');
    }

    /**
     * @Route("/company/seed")
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
        $user->setRoles(['ROLE_SCHOOL']);
        $user->setPhone('0606060606');

        $company = new Company();
        $company->setName('Sogeti');
        $company->setFluxXml("http://jobs.contactrh.com/get/XAePWe9fIg0G?client=sogeti");


        $em = $this->getDoctrine()->getManager();
        $em->persist($company);
        $em->flush();

        $user->setCompany($company);

        $em->persist($user);
        $em->flush();

        return $this->render(':default:index.html.twig');
    }
}