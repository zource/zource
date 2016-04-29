<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Email;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use ZourceUser\V1\Rest\Account\AccountEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_email")
 */
class EmailEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary")
     * @var UuidInterface
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceUser\V1\Rest\Account\AccountEntity")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var AccountEntity
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
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $validated;

    /**
     * Initializes a new instance of this class.
     *
     * @param AccountEntity $account The account to which the e-mail address belongs.
     * @param string $address The e-mail address.
     */
    public function __construct(AccountEntity $account, $address)
    {
        $this->id = Uuid::uuid4();
        $this->account = $account;
        $this->address = $address;
        $this->isPrimary = false;
        $this->validated = false;
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
     * @return AccountEntity
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
    public function getPrimary()
    {
        return $this->isPrimary;
    }

    /**
     * Gets a flag that indicates whether or not the e-mail address is validated.
     *
     * @return boolean
     */
    public function getValidated()
    {
        return $this->validated;
    }
}
