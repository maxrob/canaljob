<?php

namespace AppBundle\Repository;

use AppBundle\Entity\FluxFormationField;
use Doctrine\ORM\EntityRepository;

/**
 * FluxFormationFieldRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FluxFormationFieldRepository extends EntityRepository
{
    public function findOneOrCreate(array $name)
    {
        $entity = $this->findOneBy($name);

        if (null === $entity)
        {
            $entity = new FluxFormationField();
            $entity->setName($name['name']);
            $this->_em->persist($entity);
            $this->_em->flush();
        }

        return $entity;
    }

    public function getNotComplete()
    {
        $entities = $this->createQueryBuilder('fff')
                        ->where('fff.formationField IS NULL')
                        ->getQuery()
                        ->getResult();

        return $entities;
    }
}
