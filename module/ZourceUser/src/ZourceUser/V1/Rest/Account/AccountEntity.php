<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Account;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use ZourceUser\V1\Rest\Email\EmailEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_account")
 */
class AccountEntity
{
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_INVITED = 2;

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
     * @ORM\Column(type="string", length=60)
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
     * @ORM\ManyToMany(targetEntity="ZourceUser\Entity\Group", inversedBy="users")
     * @ORM\JoinTable(name="user_account_group",
     *     joinColumns={@ORM\JoinColumn(onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(onDelete="CASCADE")}
     * )
     * @var Collection
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity="ZourceUser\V1\Rest\Email\EmailEntity", mappedBy="account")
     * @var EmailEntity
     */
    private $emailAddresses;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->creationDate = new DateTime();
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
     * Gets the groups of this account.
     *
     * @return Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @return Collection
     */
    public function getEmailAddresses()
    {
        return $this->emailAddresses;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return 'Walter Tamboer';
    }
}
