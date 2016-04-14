<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function getJobManager() {
        return $this->get('job.manager');
    }

    public function getFormationManager() {
        return $this->get('formation.manager');
    }

    public function getFluxFormationFieldManager() {
        return $this->get('flux_formation_field.manager');
    }

    public function getFluxFormationTypeManager() {
        return $this->get('flux_formation_type.manager');
    }

    public function getFluxJobFieldManager() {
        return $this->get('flux_job_field.manager');
    }

    public function getFluxJobTypeManager() {
        return $this->get('flux_job_type.manager');
    }
}
