<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use ZourceContact\Entity\Person;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_account")
 */
class Account implements AccountInterface
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
     * @ORM\ManyToOne(targetEntity="ZourceContact\Entity\Person", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @var Person
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     * @var string|null
     */
    private $credential;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     * @var string|null
     */
    private $resetCredentialCode;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $status;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $twoFactorAuthenticationType;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $twoFactorAuthenticationCode;

    /**
     * @ORM\ManyToMany(targetEntity="ZourceUser\Entity\Group", mappedBy="accounts", cascade={"all"})
     * @var Collection
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity="ZourceUser\Entity\Email", mappedBy="account", cascade={"all"})
     * @var Email
     */
    private $emailAddresses;

    /**
     * Initializes a new instance of this class.
     *
     * @param Person $contactPerson The person to attach this account to.
     */
    public function __construct(Person $contactPerson)
    {
        $this->id = Uuid::uuid4();
        $this->creationDate = new DateTime();
        $this->contact = $contactPerson;
        $this->status = self::STATUS_ACTIVE;
        $this->groups = new ArrayCollection();
        $this->emailAddresses = new ArrayCollection();
    }

    /**
     * Gets the identifier of the account.
     *
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
     * @return Person
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @return null|string
     */
    public function getCredential()
    {
        return $this->credential;
    }

    /**
     * @param null|string $credential
     */
    public function setCredential($credential)
    {
        $this->credential = $credential;
    }

    /**
     * @return null|string
     */
    public function getResetCredentialCode()
    {
        return $this->resetCredentialCode;
    }

    /**
     * @param null|string $resetCredentialCode
     */
    public function setResetCredentialCode($resetCredentialCode)
    {
        $this->resetCredentialCode = $resetCredentialCode;
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
    public function getTwoFactorAuthenticationType()
    {
        return $this->twoFactorAuthenticationType;
    }

    /**
     * @param mixed $twoFactorAuthenticationType
     */
    public function setTwoFactorAuthenticationType($twoFactorAuthenticationType)
    {
        $this->twoFactorAuthenticationType = $twoFactorAuthenticationType;
    }

    /**
     * @return null|string
     */
    public function getTwoFactorAuthenticationCode()
    {
        return $this->twoFactorAuthenticationCode;
    }

    /**
     * @param null|string $twoFactorAuthenticationCode
     */
    public function setTwoFactorAuthenticationCode($twoFactorAuthenticationCode)
    {
        $this->twoFactorAuthenticationCode = $twoFactorAuthenticationCode;
    }

    /**
     * Checks if Two Factor Authentication is enabeld for this account.
     *
     * @return bool
     */
    public function hasTwoFactorAuthentication()
    {
        return $this->getTwoFactorAuthenticationType() !== null;
    }

    /**
     * @param Group $group
     */
    public function addGroup(Group $group)
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);

            $group->addAccount($this);
        }
    }

    /**
     * Gets the groups of this account.
     *
     * @return Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param Group $group
     */
    public function removeGroup(Group $group)
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);

            $group->removeAccount($this);
        }
    }

    /**
     * @param Collection $groups
     */
    public function setGroups($groups)
    {
        foreach ($this->groups as $group) {
            $this->removeGroup($group);
        }

        $this->groups->clear();

        foreach ($groups as $group) {
            $this->addGroup($group);
        }
    }

    /**
     * @return Collection
     */
    public function getEmailAddresses()
    {
        return $this->emailAddresses;
    }
}
