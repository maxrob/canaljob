<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobField
 *
 * @ORM\Table(name="job_field")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobFieldRepository")
 */
class JobField
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
     * @ORM\OneToMany(targetEntity="Job", mappedBy="jobField")
     */
    protected $jobs;

    /**
     * @ORM\OneToOne(targetEntity="FluxJobField", mappedBy="jobField")
     */
    private $fluxJobFields;



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
     * @return JobField
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

    /**
     * @return mixed
     */
    public function getFluxJobFields()
    {
        return $this->fluxJobFields;
    }

    /**
     * @param mixed $fluxJobFields
     */
    public function setFluxJobFields($fluxJobFields)
    {
        $this->fluxJobFields = $fluxJobFields;
    }
}
