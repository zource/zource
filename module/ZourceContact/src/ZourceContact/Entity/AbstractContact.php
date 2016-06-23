<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractContact
{
    /**
     * @ORM\Id
     * @var UuidInterface
     */
    protected $id;

    /**
     * @var DateTime
     */
    protected $creationDate;

    /**
     * @var DateTime
     */
    protected $lastUpdated;

    /**
     * @var string|null
     */
    protected $displayName;

    /**
     * @var string|null
     */
    protected $notes;

    /**
     * @var Collection
     */
    protected $emailAddresses;

    /**
     * @var Collection
     */
    protected $imppAddresses;

    /**
     * @var Collection
     */
    protected $phoneNumbers;

    /**
     * @var Collection
     */
    protected $dates;

    /**
     * @var Collection
     */
    protected $properties;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->creationDate = new DateTime();
        $this->lastUpdated = new DateTime();
        $this->emailAddresses = new ArrayCollection();
        $this->imppAddresses = new ArrayCollection();
        $this->phoneNumbers = new ArrayCollection();
        $this->dates = new ArrayCollection();
        $this->properties = new ArrayCollection();
    }

    /**
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @return DateTime
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * @return null|string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param null|string $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = self::stringOrNull($displayName);
    }

    /**
     * @return null|string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param null|string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = self::stringOrNull($notes);
    }

    /**
     * @return Collection
     */
    public function getEmailAddresses()
    {
        return $this->emailAddresses;
    }

    /**
     * @return Collection
     */
    public function getImppAddresses()
    {
        return $this->imppAddresses;
    }

    /**
     * @return Collection
     */
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /**
     * @return Collection
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @return Collection
     */
    public function getProperties()
    {
        return $this->properties;
    }

    protected static function stringOrNull($value)
    {
        if ($value === '') {
            $value = null;
        } else {
            $value = (string)$value;
        }

        return $value;
    }
}
