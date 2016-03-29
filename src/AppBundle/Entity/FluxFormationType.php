<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FluxFormationType
 *
 * @ORM\Table(name="flux_formation_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FluxFormationTypeRepository")
 */
class FluxFormationType
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Formation", mappedBy="fluxFormationType")
     */
    protected $formations;

    /**
     * @ORM\ManyToOne(targetEntity="FormationType", inversedBy="fluxFormationTypes")
     * @ORM\JoinColumn(name="formation_type_id", referencedColumnName="id", nullable=true)
     */
    protected $formationType;


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
     * @return FluxFormationType
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

    /**
     * @return mixed
     */
    public function getFormationType()
    {
        return $this->formationType;
    }

    /**
     * @param mixed $formationType
     */
    public function setFormationType($formationType)
    {
        $this->formationType = $formationType;
    }
}
