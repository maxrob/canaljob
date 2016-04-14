<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/import")
 */
class ImportController extends BaseController
{
    /**
     * @Route(name="import", path="/{type}")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function importAction(Request $request, $type)
    {

        switch ($type)
        {
            case 'csv':
                $form = $this->createForm('appbundle_get_csv');
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid())
                {
                    // Get file
                    $file = $form->get('csv_file');
                    $school = $form->get('schools')->getData();

                    $parameters = [
                        "file"      => $file,
                        "school"    => $school
                    ];

                    $importService = $this->get('canal_job.import_system');

                    $importService->setParameters($parameters);
                    $importService->import();
                }

                return $this->render(':default:csv.html.twig',
                    ['form' => $form->createView()]
                );
                break;

            case 'xml':
                $parameters = [
                    "begin" => new \DateTime("2016-03-15"),
                    "end"   => new \DateTime("2016-04-15")
                ];

                $importService = $this->get('canal_job.import_system');

                $importService->setParameters($parameters);
                $importService->import();

                return $this->render(':default:csv.html.twig');
                break;

            default:
                throw new \InvalidArgumentException("$type is not defined as import service.");
                break;
        }
    }
}
