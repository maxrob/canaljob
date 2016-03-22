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
     * @ORM\Column(name="prerequisite", type="text")
     */
    private $prerequisite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin_date", type="date", nullable=true)
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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Department", inversedBy="job")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id", unique=true, nullable=true)
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="JobField", inversedBy="jobs")
     * @ORM\JoinColumn(name="job_field_id", referencedColumnName="id")
     */
    protected $jobField;

    /**
     * @ORM\ManyToOne(targetEntity="JobType", inversedBy="jobs")
     * @ORM\JoinColumn(name="job_type_id", referencedColumnName="id")
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