<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FluxFormationField
 *
 * @ORM\Table(name="flux_formation_field")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FluxFormationFieldRepository")
 */
class FluxFormationField
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
     * @ORM\OneToMany(targetEntity="Formation", mappedBy="fluxFormationField")
     */
    protected $formations;

    /**
     * @ORM\ManyToOne(targetEntity="FormationField", inversedBy="fluxFormationFields")
     * @ORM\JoinColumn(name="formation_field_id", referencedColumnName="id", nullable=true)
     */
    protected $formationField;

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
     * @return FluxFormationField
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

    /**
     * @return mixed
     */
    public function getFormations()
    {
        return $this->formations;
    }

    /**
     * @param mixed $formations
     */
    public function setFormations($formations)
    {
        $this->formations = $formations;
    }
}
