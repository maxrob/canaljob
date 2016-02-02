<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompanyRepository")
 */
class Company
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
     * @var bool
     *
     * @ORM\Column(name="is_start_up", type="boolean", nullable=true, options={"default" = 0})
     */
    private $isStartUp;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true, options={"default" = "user.png"})
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="flux_xml", type="string", length=255, nullable=true)
     */
    private $fluxXml;

    /**
     * @ORM\OneToMany(targetEntity="Job", mappedBy="company")
     */
    protected $jobs;

    /**
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\User", mappedBy="company")
     */
    protected $users;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Company
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
     * @return boolean
     */
    public function isIsStartUp()
    {
        return $this->isStartUp;
    }

    /**
     * @param boolean $isStartUp
     */
    public function setIsStartUp($isStartUp)
    {
        $this->isStartUp = $isStartUp;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public function getFluxXml()
    {
        return $this->fluxXml;
    }

    /**
     * @param string $fluxXml
     */
    public function setFluxXml($fluxXml)
    {
        $this->fluxXml = $fluxXml;
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
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }
}
