<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Formation
 *
 * @ORM\Table(name="formation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FormationRepository")
 */
class Formation extends BaseEntity
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=255, nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="perspective", type="text")
     */
    private $perspective;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=true)
     */
    private $mail;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_geoloc", type="boolean", nullable=true)
     */
    private $isGeoloc;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", options={"default" = 1})
     */
    private $status;
    // Statut 0 => Champs non valide, nécessite une correspondance ( XML )
    // Statut 1 => Champs valide, non accepté
    // Statut 2 => Champs valide et accepté

    /**
     * @ORM\OneToMany(targetEntity="FormationPeriod", mappedBy="formation")
     */
    protected $formationPeriods;

    /**
     * @ORM\ManyToOne(targetEntity="School", inversedBy="formations")
     * @ORM\JoinColumn(name="school_id", referencedColumnName="id")
     */
    protected $school;

    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="formations")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id", nullable=true)
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="FluxFormationField", inversedBy="formations")
     * @ORM\JoinColumn(name="flux_formation_field_id", referencedColumnName="id")
     */
    protected $fluxFormationField;

    /**
     * @ORM\ManyToOne(targetEntity="FluxFormationType", inversedBy="formations")
     * @ORM\JoinColumn(name="flux_formation_type_id", referencedColumnName="id")
     */
    protected $fluxFormationType;

    public function __construct()
    {
        $this->formationPeriods = new ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     * @return Formation
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Formation
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Formation
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Formation
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Formation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set perspective
     *
     * @param string $perspective
     * @return Formation
     */
    public function setPerspective($perspective)
    {
        $this->perspective = $perspective;

        return $this;
    }

    /**
     * Get perspective
     *
     * @return string 
     */
    public function getPerspective()
    {
        return $this->perspective;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Formation
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Formation
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set isGeoloc
     *
     * @param boolean $isGeoloc
     * @return Formation
     */
    public function setIsGeoloc($isGeoloc)
    {
        $this->isGeoloc = $isGeoloc;

        return $this;
    }

    /**
     * Get isGeoloc
     *
     * @return boolean 
     */
    public function getIsGeoloc()
    {
        return $this->isGeoloc;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Formation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getFormationPeriods()
    {
        return $this->formationPeriods;
    }

    /**
     * @param mixed $formationPeriods
     */
    public function setFormationPeriods($formationPeriods)
    {
        $this->formationPeriods = $formationPeriods;
    }

    /**
     * @return mixed
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * @param mixed $school
     */
    public function setSchool($school)
    {
        $this->school = $school;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    }

    /**
     * @return mixed
     */
    public function getFluxFormationField()
    {
        return $this->fluxFormationField;
    }

    /**
     * @param mixed $fluxFormationField
     */
    public function setFluxFormationField($fluxFormationField)
    {
        $this->fluxFormationField = $fluxFormationField;
    }

    /**
     * @return mixed
     */
    public function getFluxFormationType()
    {
        return $this->fluxFormationType;
    }

    /**
     * @param mixed $fluxFormationType
     */
    public function setFluxFormationType($fluxFormationType)
    {
        $this->fluxFormationType = $fluxFormationType;
    }
}
