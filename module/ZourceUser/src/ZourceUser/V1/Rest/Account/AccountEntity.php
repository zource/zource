<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Account;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_account")
 */
class AccountEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary")
     * @var UuidInterface
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="ZourceUser\V1\Rest\Group\GroupEntity", inversedBy="users")
     * @ORM\JoinTable(name="user_account_group",
     *     joinColumns={@ORM\JoinColumn(onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(onDelete="CASCADE")}
     * )
     * @var Collection
     */
    private $groups;


    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $displayName;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $displayName The display name of the account.
     */
    public function __construct($displayName)
    {
        $this->id = Uuid::uuid4();
        $this->groups = new ArrayCollection();
        $this->displayName = $displayName;
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
     * Gets the groups of this account.
     * 
     * @return Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Gets the display name of the account.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Sets the display name of the account.
     *
     * @param string $displayName The new display name of the account.
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
}
