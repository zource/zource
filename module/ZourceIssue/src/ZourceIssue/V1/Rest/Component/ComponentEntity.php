<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceIssue\V1\Rest\Component;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="issue_component")
 */
class ComponentEntity
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
     * Initializes a new instance of this class.
     *
     * @param string $name The name of the component.
     */
    public function __construct($name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
    }

    /**
     * Gets the value of id
     *
     * @return int
     */
    public function getId()
    {
        if ($this->id === null) {
            return $this->id;
        }

        return (int)$this->id;
    }

    /**
     * Sets the value of id
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Gets the value of name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
