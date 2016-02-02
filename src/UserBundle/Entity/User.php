<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   *
   * @ORM\Column(type="string", length=255, name="civility", nullable=true)
   */
  protected $civility;

  /**
   * @var string
   *
   * @ORM\Column(type="string", length=255, name="firstname")
   */
  protected $firstname;

  /**
   * @var string
   *
   * @ORM\Column(type="string", length=255, name="lastname")
   */
  protected $lastname;

  /**
   * @var string
   *
   * @ORM\Column(type="string", length=255, name="phone")
   */
  protected $phone;

  /**
   * @var string
   *
   * @ORM\Column(type="string", length=255, name="second_phone", nullable=true)
   */
  protected $secondPhone;

  /**
   * @var boolean
   *
   * @ORM\Column(type="boolean", name="newsletter", nullable=true, options={"default" = 0})
   */
  protected $newletter;

  /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\School", inversedBy="users")
   * @ORM\JoinColumn(name="school_id", referencedColumnName="id", nullable=true)
   */
  protected $school;

  /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company", inversedBy="users")
   * @ORM\JoinColumn(name="company_id", referencedColumnName="id", nullable=true)
   */
  protected $company;

  /**
   * @ORM\OneToOne(targetEntity="AppBundle\Entity\Applicant", inversedBy="user")
   * @ORM\JoinColumn(name="applicant_id", referencedColumnName="id", unique=true, nullable=true)
   */
  private $applicant;

  /**
   * @var \DateTime $createdAt
   *
   * @Gedmo\Timestampable(on="create")
   * @ORM\Column(type="datetime")
   */
  protected $createdAt;

  /**
   * @var \DateTime $updatedAt
   *
   * @Gedmo\Timestampable(on="update")
   * @ORM\Column(type="datetime")
   */
  protected $updatedAt;

  /**
   * @var \DateTime $deletedAt
   *
   * @ORM\Column(type="datetime", nullable=true)
   */
  protected $deletedAt;


  public function __construct()
  {
    parent::__construct();
  }

  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
   * @return string
   */
  public function getCivility()
  {
    return $this->civility;
  }

  /**
   * @param string $civility
   */
  public function setCivility($civility)
  {
    $this->civility = $civility;
  }

  /**
   * @return string
   */
  public function getFirstname()
  {
    return $this->firstname;
  }

  /**
   * @param string $firstname
   */
  public function setFirstname($firstname)
  {
    $this->firstname = $firstname;
  }

  /**
   * @return string
   */
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * @param string $lastname
   */
  public function setLastname($lastname)
  {
    $this->lastname = $lastname;
  }

  /**
   * @return string
   */
  public function getPhone()
  {
    return $this->phone;
  }

  /**
   * @param string $phone
   */
  public function setPhone($phone)
  {
    $this->phone = $phone;
  }

  /**
   * @return string
   */
  public function getSecondPhone()
  {
    return $this->secondPhone;
  }

  /**
   * @param string $secondPhone
   */
  public function setSecondPhone($secondPhone)
  {
    $this->secondPhone = $secondPhone;
  }

  /**
   * @return boolean
   */
  public function isNewletter()
  {
    return $this->newletter;
  }

  /**
   * @param boolean $newletter
   */
  public function setNewletter($newletter)
  {
    $this->newletter = $newletter;
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
  public function getApplicant()
  {
    return $this->applicant;
  }

  /**
   * @param mixed $applicant
   */
  public function setApplicant($applicant)
  {
    $this->applicant = $applicant;
  }

  /**
   * @return \DateTime
   */
  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  /**
   * @param \DateTime $createdAt
   */
  public function setCreatedAt($createdAt)
  {
    $this->createdAt = $createdAt;
  }

  /**
   * @return \DateTime
   */
  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  /**
   * @param \DateTime $updatedAt
   */
  public function setUpdatedAt($updatedAt)
  {
    $this->updatedAt = $updatedAt;
  }

  /**
   * @return \DateTime
   */
  public function getDeletedAt()
  {
    return $this->deletedAt;
  }

  /**
   * @param \DateTime $deletedAt
   */
  public function setDeletedAt($deletedAt)
  {
    $this->deletedAt = $deletedAt;
  }

}