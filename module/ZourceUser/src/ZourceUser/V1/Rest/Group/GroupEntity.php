<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Group;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_group")
 */
class GroupEntity
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
     * @ORM\ManyToMany(targetEntity="ZourceUser\V1\Rest\Account\AccountEntity", mappedBy="groups")
     * @var Collection
     */
    private $users;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $name The name of the group.
     */
    public function __construct($name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->users = new ArrayCollection();
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
}
