<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class JobManager
{
    private $em;
    private $repository;


    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('AppBundle:Job');
    }

    public function findJobs($data)
    {
        $title = $data['title'];

        $departments = [];
        foreach($data['departments'] as $department) {
            $departments[] = $department->getId();
        }

        $job_field = $data['job_field']->getId();

        $job_types = [];
        foreach($data['job_type'] as $job_type) {
            $job_types[] = $job_type->getId();
        }

        $jobs = $this->getRepository()->findJobs($title, $departments, $job_field, $job_types);

        return $jobs;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param Array $job
     * @return bool
     */
    public function save($job)
    {
        $this->em->persist($job);
        $this->em->flush();

        return $job->getId();
    }

    public function delete($job)
    {
        $this->em->remove($job);
        $this->em->flush();
    }
}