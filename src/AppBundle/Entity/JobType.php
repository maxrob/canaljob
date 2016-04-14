<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobType
 *
 * @ORM\Table(name="job_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobTypeRepository")
 */
class JobType
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
     * @ORM\OneToMany(targetEntity="FluxJobType", mappedBy="jobType")
     */
    private $fluxJobTypes;

    /**
     * @ORM\OneToMany(targetEntity="Job", mappedBy="jobType")
     */
    private $jobs;

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
     * @return JobType
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
    public function getFluxJobTypes()
    {
        return $this->fluxJobTypes;
    }

    /**
     * @param mixed $fluxJobTypes
     */
    public function setFluxJobTypes($fluxJobTypes)
    {
        $this->fluxJobTypes = $fluxJobTypes;
    }

    /**
     * @return mixed
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * @param mixed $jobs
     */
    public function setJobs($jobs)
    {
        $this->jobs = $jobs;
    }

}
