<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Department
 *
 * @ORM\Table(name="department")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartmentRepository")
 */
class Department
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Job", mappedBy="department")
     */
    private $jobs;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Formation", mappedBy="department")
     */
    private $formations;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Department
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getJob()
    {
        return $this->jobs;
    }

    /**
     * @param mixed $job
     */
    public function setJob($job)
    {
        $this->jobs = $job;
    }

    /**
     * @return mixed
     */
    public function getFormation()
    {
        return $this->formations;
    }

    /**
     * @param mixed $formation
     */
    public function setFormation($formation)
    {
        $this->formations = $formation;
    }


}
