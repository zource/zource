<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Entity;
use InvalidArgumentException;

/**
 * The representation of a person.
 */
final class Person extends AbstractContact
{
    const GENDER_UNKNOWN = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_NA = 9;

    /**
     * The gender of this person. Format according ISO IEC_5218
     *
     * @var int
     */
    private $gender;

    /**
     * @var string|null
     */
    private $prefix;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $phoneticFirstName;

    /**
     * @var string|null
     */
    private $middleName;

    /**
     * @var string|null
     */
    private $phoneticMiddleName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var string|null
     */
    private $phoneticLastName;

    /**
     * @var string|null
     */
    private $maidenName;

    /**
     * @var string|null
     */
    private $suffix;

    /**
     * @var string|null
     */
    private $nickname;

    /**
     * @var string|null
     */
    private $jobTitle;

    /**
     * @var string|null
     */
    private $department;

    /**
     * @var string|null
     */
    private $company;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $firstName The first name of the person.
     * @param string $lastName The last name of the person.
     */
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
        switch ($gender) {
            case self::GENDER_UNKNOWN:
            case self::GENDER_FEMALE:
            case self::GENDER_MALE:
            case self::GENDER_NA:
                $this->gender = (int)$gender;
                break;

            default:
                throw new InvalidArgumentException('An invalid argument was provided.');
        }
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
        $this->prefix = self::stringOrNull($prefix);
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
        $this->firstName = self::stringOrNull($firstName);
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
        $this->phoneticFirstName = self::stringOrNull($phoneticFirstName);
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
        $this->middleName = self::stringOrNull($middleName);
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
        $this->phoneticMiddleName = self::stringOrNull($phoneticMiddleName);
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
        $this->lastName = self::stringOrNull($lastName);
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
        $this->phoneticLastName = self::stringOrNull($phoneticLastName);
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
        $this->maidenName = self::stringOrNull($maidenName);
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
        $this->suffix = self::stringOrNull($suffix);
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
        $this->nickname = self::stringOrNull($nickname);
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
        $this->jobTitle = self::stringOrNull($jobTitle);
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
        $this->department = self::stringOrNull($department);
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
        $this->company = self::stringOrNull($company);
    }

    private static function stringOrNull($value)
    {
        if ($value === '') {
            $value = null;
        } else {
            $value = (string)$value;
        }

        return $value;
    }
}
