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

/**
 * @ORM\Entity
 * @ORM\Table(name="user_identity")
 */
class Identity implements IdentityInterface
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
     * The directory that this identity is in.
     *
     * @ORM\Column(type="string")
     * @var string
     */
    private $directory;

    /**
     * The identity representation.
     *
     * @ORM\Column(type="string")
     * @var string
     */
    private $identity;

    /**
     * Initializes a new instance of this class.
     *
     * @param AccountInterface $account The account to which this entity belongs.
     * @param string $directory The directory of the identity.
     * @param string $identity The identity representation.
     */
    public function __construct(AccountInterface $account, $directory, $identity)
    {
        $this->id = Uuid::uuid4();
        $this->account = $account;
        $this->directory = $directory;
        $this->identity = $identity;
    }

    /**
     * Gets the id of the identity.
     *
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the account for this identity.
     *
     * @return AccountInterface
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Gets the directory in which this identity resides.
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Gets the identity value.
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }
}
