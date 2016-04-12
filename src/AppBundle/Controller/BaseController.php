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
}
