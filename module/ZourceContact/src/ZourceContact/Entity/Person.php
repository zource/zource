<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact_person")
 */
class Person extends AbstractContact
{
    const GENDER_UNKNOWN = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_NA = 9;

    /**
     * The gender of this person. Format according ISO IEC_5218
     *
     * @ORM\Column(type="integer")
     * @var int
     */
    private $gender;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $prefix;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $phoneticFirstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $pronunciationFirstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $middleName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $phoneticMiddleName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $phoneticLastName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $pronunciationLastName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $maidenName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $suffix;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $nickname;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $jobTitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $department;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $company;

    public function __construct($firstName, $lastName)
    {
        parent::__construct();

        $this->setGender(self::GENDER_UNKNOWN);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    /**
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return null|string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param null|string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return null|string
     */
    public function getPhoneticFirstName()
    {
        return $this->phoneticFirstName;
    }

    /**
     * @param null|string $phoneticFirstName
     */
    public function setPhoneticFirstName($phoneticFirstName)
    {
        $this->phoneticFirstName = $phoneticFirstName;
    }

    /**
     * @return null|string
     */
    public function getPronunciationFirstName()
    {
        return $this->pronunciationFirstName;
    }

    /**
     * @param null|string $pronunciationFirstName
     */
    public function setPronunciationFirstName($pronunciationFirstName)
    {
        $this->pronunciationFirstName = $pronunciationFirstName;
    }

    /**
     * @return null|string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param null|string $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * @return null|string
     */
    public function getPhoneticMiddleName()
    {
        return $this->phoneticMiddleName;
    }

    /**
     * @param null|string $phoneticMiddleName
     */
    public function setPhoneticMiddleName($phoneticMiddleName)
    {
        $this->phoneticMiddleName = $phoneticMiddleName;
    }

    /**
     * @return null|string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param null|string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return null|string
     */
    public function getPhoneticLastName()
    {
        return $this->phoneticLastName;
    }

    /**
     * @param null|string $phoneticLastName
     */
    public function setPhoneticLastName($phoneticLastName)
    {
        $this->phoneticLastName = $phoneticLastName;
    }

    /**
     * @return null|string
     */
    public function getPronunciationLastName()
    {
        return $this->pronunciationLastName;
    }

    /**
     * @param null|string $pronunciationLastName
     */
    public function setPronunciationLastName($pronunciationLastName)
    {
        $this->pronunciationLastName = $pronunciationLastName;
    }

    /**
     * @return null|string
     */
    public function getMaidenName()
    {
        return $this->maidenName;
    }

    /**
     * @param null|string $maidenName
     */
    public function setMaidenName($maidenName)
    {
        $this->maidenName = $maidenName;
    }

    /**
     * @return null|string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @param null|string $suffix
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * @return null|string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param null|string $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return null|string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * @param null|string $jobTitle
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

    /**
     * @return null|string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param null|string $department
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    }

    /**
     * @return null|string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param null|string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }
}
