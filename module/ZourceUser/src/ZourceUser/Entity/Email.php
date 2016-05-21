<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use ZourceUser\Entity\AccountInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_email")
 */
class Email
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary")
     * @var UuidInterface
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceUser\Entity\AccountInterface")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var AccountInterface
     */
    private $account;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $address;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $isPrimary;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $validationCode;

    /**
     * Initializes a new instance of this class.
     *
     * @param AccountInterface $account The account to which the e-mail address belongs.
     * @param string $address The e-mail address.
     */
    public function __construct(AccountInterface $account, $address)
    {
        $this->id = Uuid::uuid4();
        $this->account = $account;
        $this->address = $address;
        $this->isPrimary = false;
        $this->validationCode = null;
    }

    /**
     * Gets the identifier of the email address.
     *
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the account to which this e-mail address belongs.
     *
     * @return AccountInterface
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Gets the representation of the e-mail address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Gets the flag that indicates whether or not this e-mail address is a primary address.
     *
     * @return boolean
     */
    public function getIsPrimary()
    {
        return $this->isPrimary;
    }

    /**
     * Sets the flag that indicates whether or not this e-mail address is a primary address.
     *
     * @param boolean $isPrimary
     */
    public function setIsPrimary($isPrimary)
    {
        $this->isPrimary = $isPrimary;
    }

    /**
     * Gets the validation code for this e-mail address.
     *
     * @return null|string
     */
    public function getValidationCode()
    {
        return $this->validationCode;
    }

    /**
     * Sets the validation code for this e-mail address.
     *
     * @param null|string $validationCode
     */
    public function setValidationCode($validationCode)
    {
        $this->validationCode = $validationCode;
    }

    /**
     * Checks if the email address is verified.
     *
     * @return bool
     */
    public function isVerified()
    {
        return $this->getValidationCode() === null;
    }
}
