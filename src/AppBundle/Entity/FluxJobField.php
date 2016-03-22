<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FluxJobField
 *
 * @ORM\Table(name="flux_job_field")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FluxJobFieldRepository")
 */
class FluxJobField
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
     * @ORM\ManyToOne(targetEntity="JobField", inversedBy="fluxJobFields")
     * @ORM\JoinColumn(name="job_field_id", referencedColumnName="id", nullable=true)
     */
    protected $jobField;

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
     * @return FluxJobField
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
    public function getJobField()
    {
        return $this->jobField;
    }

    /**
     * @param mixed $jobField
     */
    public function setJobField($jobField)
    {
        $this->jobField = $jobField;
    }
}
