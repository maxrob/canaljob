<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormationType
 *
 * @ORM\Table(name="formation_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationTypeRepository")
 */
class FormationType
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
     * @ORM\OneToOne(targetEntity="FluxFormationType", mappedBy="formationType")
     */
    private $fluxFormationTypes;

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
     * @return FormationType
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
    public function getFluxFormationTypes()
    {
        return $this->fluxFormationTypes;
    }

    /**
     * @param mixed $fluxFormationTypes
     */
    public function setFluxFormationTypes($fluxFormationTypes)
    {
        $this->fluxFormationTypes = $fluxFormationTypes;
    }

}
