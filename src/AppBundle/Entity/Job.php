<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobRepository")
 */
class Job extends BaseEntity
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="prerequisite", type="text")
     */
    private $prerequisite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin_date", type="date")
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

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
     * @var float
     *
     * @ORM\Column(name="salary_min", type="float", nullable=true)
     */
    private $salaryMin;

    /**
     * @var float
     *
     * @ORM\Column(name="salary_max", type="float", nullable=true)
     */
    private $salaryMax;

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
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="jobs")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

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
     * @return Job
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
     * @return Job
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
     * @param string $latitude
     * @return Job
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Job
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
     * Set description
     *
     * @param string $description
     * @return Job
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
     * Set prerequisite
     *
     * @param string $prerequisite
     * @return Job
     */
    public function setPrerequisite($prerequisite)
    {
        $this->prerequisite = $prerequisite;

        return $this;
    }

    /**
     * Get prerequisite
     *
     * @return string 
     */
    public function getPrerequisite()
    {
        return $this->prerequisite;
    }

    /**
     * Set beginDate
     *
     * @param \DateTime $beginDate
     * @return Job
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * Get beginDate
     *
     * @return \DateTime 
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Job
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Job
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
     * @return Job
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
     * @return Job
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
     * Set salaryMin
     *
     * @param float $salaryMin
     * @return Job
     */
    public function setSalaryMin($salaryMin)
    {
        $this->salaryMin = $salaryMin;

        return $this;
    }

    /**
     * Get salaryMin
     *
     * @return float 
     */
    public function getSalaryMin()
    {
        return $this->salaryMin;
    }

    /**
     * Set salaryMax
     *
     * @param float $salaryMax
     * @return Job
     */
    public function setSalaryMax($salaryMax)
    {
        $this->salaryMax = $salaryMax;

        return $this;
    }

    /**
     * Get salaryMax
     *
     * @return float 
     */
    public function getSalaryMax()
    {
        return $this->salaryMax;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Job
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
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }
}
