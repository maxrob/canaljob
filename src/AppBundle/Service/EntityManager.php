<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager as EM;

class EntityManager
{
    public function __construct(EM $em)
    {
        $this->em = $em;
    }
}