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
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $familyName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $nickname;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var DateTimeInterface|null
     */
    private $dateOfBirth;

    public function __construct($name, $familyName)
    {
        parent::__construct();

        $this->gender = self::GENDER_UNKNOWN;
        $this->name = $name;
        $this->familyName = $familyName;
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
        $this->makeDirty();

        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->makeDirty();

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFamilyName()
    {
        return $this->familyName;
    }

    /**
     * @param string $familyName
     */
    public function setFamilyName($familyName)
    {
        $this->makeDirty();

        $this->familyName = $familyName;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getName() . ' ' . $this->getFamilyName();
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
        $this->makeDirty();

        $this->nickname = $nickname;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param DateTimeInterface|null $dateOfBirth
     */
    public function setDateOfBirth(DateTimeInterface $dateOfBirth = null)
    {
        $this->makeDirty();

        $this->dateOfBirth = $dateOfBirth;
    }
}
