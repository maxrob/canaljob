<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class FormationManager
{
    private $em;
    private $repository;


    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('AppBundle:Formation');
    }

    public function findFormations($data)
    {
        $title = $data['title'];

        $departments = [];
        foreach($data['departments'] as $department) {
            $departments[] = $department->getId();
        }

        $formation_field = $data['formation_field']->getId();

        $formation_types = [];
        foreach($data['formation_type'] as $formation_type) {
            $formation_types[] = $formation_type->getId();
        }

        $jobs = $this->getRepository()->findFormations($title, $departments, $formation_field, $formation_types);

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
     * @param $formation
     * @return mixed
     */
    public function save($formation)
    {
        $this->em->persist($formation);
        $this->em->flush();

        return $formation->getId();
    }

    public function delete($formation)
    {
        $this->em->remove($formation);
        $this->em->flush();
    }
}