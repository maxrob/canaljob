<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormationField
 *
 * @ORM\Table(name="formation_field")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationFieldRepository")
 */
class FormationField
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
     * @ORM\OneToMany(targetEntity="Formation", mappedBy="formationField")
     */
    protected $formations;

    /**
     * @ORM\OneToOne(targetEntity="FluxFormationField", mappedBy="formationField")
     */
    private $fluxFormationFields;

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
     * @return FormationField
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
    public function getFluxFormationFields()
    {
        return $this->fluxFormationFields;
    }

    /**
     * @param mixed $fluxFormationFields
     */
    public function setFluxFormationFields($fluxFormationFields)
    {
        $this->fluxFormationFields = $fluxFormationFields;
    }
}
