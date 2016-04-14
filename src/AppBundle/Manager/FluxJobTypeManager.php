<?php

namespace AppBundle\Manager;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class FluxJobTypeManager
{
    private $em;
    private $repository;


    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('AppBundle:FluxJobType');
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
    }}