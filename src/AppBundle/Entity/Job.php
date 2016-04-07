<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotNull
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotNull
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @Assert\NotNull
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @Assert\NotNull
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
     * @Assert\NotNull
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @Assert\NotNull
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @Assert\NotNull
     * @var string
     *
     * @ORM\Column(name="prerequisite", type="text")
     */
    private $prerequisite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin_date", type="datetime", nullable=true)
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
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
     * @ORM\Column(name="is_geoloc", type="boolean", nullable=true, options={"default" = false})
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
     * @var string
     *
     * @ORM\Column(name="salary_type", type="string", nullable=true)
     */
    private $salaryType;

    /**
     * @Assert\NotNull
     * @var int
     *
     * @ORM\Column(name="status", type="integer", options={"default" = 1})
     */
    private $status;
    // Statut 0 => Champs non valide, nécessite une correspondance ( XML )
    // Statut 1 => Champs valide, non accepté
    // Statut 2 => Champs valide et accepté

    /**
     * @Assert\NotNull
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="jobs")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Department", inversedBy="jobs")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id", nullable=true)
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="FluxJobField", inversedBy="jobs")
     * @ORM\JoinColumn(name="flux_job_field_id", referencedColumnName="id", nullable=true)
     */
    protected $fluxJobField;

    /**
     * @ORM\ManyToOne(targetEntity="FluxJobType", inversedBy="jobs")
     * @ORM\JoinColumn(name="flux_job_type_id", referencedColumnName="id", nullable=true)
     */
    protected $fluxJobType;

    /**
     * @ORM\ManyToOne(targetEntity="JobField", inversedBy="jobs")
     * @ORM\JoinColumn(name="job_field_id", referencedColumnName="id", nullable=true)
     */
    protected $jobField;

    /**
     * @ORM\ManyToOne(targetEntity="JobType", inversedBy="jobs")
     * @ORM\JoinColumn(name="job_type_id", referencedColumnName="id", nullable=true)
     */
    protected $jobType;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPrerequisite()
    {
        return $this->prerequisite;
    }

    /**
     * @param string $prerequisite
     */
    public function setPrerequisite($prerequisite)
    {
        $this->prerequisite = $prerequisite;
    }

    /**
     * @return \DateTime
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * @param \DateTime $beginDate
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return boolean
     */
    public function isIsGeoloc()
    {
        return $this->isGeoloc;
    }

    /**
     * @param boolean $isGeoloc
     */
    public function setIsGeoloc($isGeoloc)
    {
        $this->isGeoloc = $isGeoloc;
    }

    /**
     * @return mixed
     */
    public function getFluxJobField()
    {
        return $this->fluxJobField;
    }

    /**
     * @param mixed $fluxJobField
     */
    public function setFluxJobField($fluxJobField)
    {
        $this->fluxJobField = $fluxJobField;
    }

    /**
     * @return mixed
     */
    public function getFluxJobType()
    {
        return $this->fluxJobType;
    }

    /**
     * @param mixed $fluxJobType
     */
    public function setFluxJobType($fluxJobType)
    {
        $this->fluxJobType = $fluxJobType;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return float
     */
    public function getSalaryMin()
    {
        return $this->salaryMin;
    }

    /**
     * @param float $salaryMin
     */
    public function setSalaryMin($salaryMin)
    {
        $this->salaryMin = $salaryMin;
    }

    /**
     * @return float
     */
    public function getSalaryMax()
    {
        return $this->salaryMax;
    }

    /**
     * @param float $salaryMax
     */
    public function setSalaryMax($salaryMax)
    {
        $this->salaryMax = $salaryMax;
    }

    /**
     * @return string
     */
    public function getSalaryType()
    {
        return $this->salaryType;
    }

    /**
     * @param string $salaryType
     */
    public function setSalaryType($salaryType)
    {
        $this->salaryType = $salaryType;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
    public function getJobType()
    {
        return $this->jobType;
    }

    /**
     * @param mixed $jobType
     */
    public function setJobType($jobType)
    {
        $this->jobType = $jobType;
    }




}