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

/**
 * @ORM\Entity
 * @ORM\Table(name="contact")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="contact_type", type="string")
 * @ORM\DiscriminatorMap({"company" = "Company", "person" = "Person"})
 */
abstract class AbstractContact
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary")
     * @var UuidInterface
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $creationDate;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $lastUpdated;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity="ImppAddress", mappedBy="contact")
     * @var Collection
     */
    private $imppAddresses;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->creationDate = new DateTime();
        $this->lastUpdated = new DateTime();
        $this->imppAddresses = new ArrayCollection();
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
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param null|string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
}
