<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * School
 *
 * @ORM\Table(name="school")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SchoolRepository")
 */
class School
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
     * @ORM\Column(name="is_only_online", type="boolean", nullable=true, options={"default" = 0})
     */
    private $isOnlyOnline;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true, options={"default" = "user.png"})
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="Formation", mappedBy="school")
     */
    protected $formations;

    /**
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\User", mappedBy="school")
     */
    protected $users;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
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
     * @return School
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
     * Set isOnlyOnline
     *
     * @param boolean $isOnlyOnline
     * @return School
     */
    public function setIsOnlyOnline($isOnlyOnline)
    {
        $this->isOnlyOnline = $isOnlyOnline;

        return $this;
    }

    /**
     * Get isOnlyOnline
     *
     * @return boolean 
     */
    public function getIsOnlyOnline()
    {
        return $this->isOnlyOnline;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return School
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
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
