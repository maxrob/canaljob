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
        $formationManager = $this->getFormationManager();
        $form_job = $this->createForm('appbundle_home_search_job');
        $form_job->handleRequest($request);

        $form_formation = $this->createForm('appbundle_home_search_formation');
        $form_formation->handleRequest($request);

        if ($form_job->isSubmitted() && $form_job->isValid())
        {
            $jobs = $jobManager->findJobs($form_job->getData());
            return $this->render(':default:home.html.twig', [
                'form_job' => $form_job->createView(),
                'form_formation' => $form_formation->createView(),
                'jobs' => $jobs,
            ]);
        }

        if ($form_formation->isSubmitted() && $form_formation->isValid())
        {
            $formations = $formationManager->findFormations($form_formation->getData());
            return $this->render(':default:home.html.twig', [
                'form_job' => $form_job->createView(),
                'form_formation' => $form_formation->createView(),
                'formations' => $formations,
            ]);
        }

        return $this->render(':default:home.html.twig', [
            'form_job' => $form_job->createView(),
            'form_formation' => $form_formation->createView()
        ]);
    }
}
