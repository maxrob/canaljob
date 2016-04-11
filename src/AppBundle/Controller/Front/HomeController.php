<?php

namespace AppBundle\Controller\Front;

use AppBundle\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends BaseController
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request) {

        $jobManager = $this->getJobManager();
        $form = $this->createForm('appbundle_home_search');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $jobs = $jobManager->findJobs($form->getData());
            return $this->render(':default:home.html.twig', [
                'form' => $form->createView(),
                'jobs' => $jobs,
            ]);
        }

        return $this->render(':default:home.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
