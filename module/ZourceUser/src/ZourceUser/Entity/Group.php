<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_group")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary")
     * @var UuidInterface
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @var string[]
     */
    private $permissions;

    /**
     * @ORM\ManyToMany(targetEntity="ZourceUser\Entity\AccountInterface", inversedBy="groups")
     * @ORM\JoinTable(name="user_group_account",
     *     joinColumns={@ORM\JoinColumn(onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(onDelete="CASCADE")}
     * )
     * @var Collection
     */
    private $accounts;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $name The name of the group.
     */
    public function __construct($name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->permissions = [];
        $this->accounts = new ArrayCollection();
    }

    /**
     * Gets the identifier of the group.
     *
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the name of the group.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the group.
     *
     * @param string $name The new name of the group.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param string[] $permissions
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
    }
    
    public function addAccount(AccountInterface $account)
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts->add($account);

            $account->addGroup($this);
        }
    }

    /**
     * @return Collection
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    public function removeAccount(AccountInterface $account)
    {
        if ($this->accounts->contains($account)) {
            $this->accounts->removeElement($account);

            $account->removeGroup($this);
        }
    }

    /**
     * @param Collection $accounts
     */
    public function setAccounts(Collection $accounts)
    {
        foreach ($this->accounts as $account) {
            $account->removeGroup($this);

            $this->accounts->removeElement($account);
        }

        foreach ($accounts as $account) {
            $this->addAccount($account);
        }
    }
}
