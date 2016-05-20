<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceProject\V1\Rest\Project;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use ZourceProject\V1\Rest\Category\CategoryEntity;
use ZourceUser\Entity\AccountInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="project")
 */
class ProjectEntity
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
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $projectKey;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceProject\V1\Rest\Category\CategoryEntity")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var CategoryEntity
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceUser\Entity\AccountInterface")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var AccountInterface
     */
    private $lead;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->creationDate = new DateTime();
    }

    /**
     * Gets the value of id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Gets the value of creationDate
     *
     * @return DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Sets the value of creationDate
     *
     * @param DateTime $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
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

    /**
     * Gets the value of projectKey
     *
     * @return string
     */
    public function getProjectKey()
    {
        return $this->projectKey;
    }

    /**
     * Sets the value of projectKey
     *
     * @param string $projectKey
     */
    public function setProjectKey($projectKey)
    {
        $this->projectKey = $projectKey;
    }

    /**
     * Gets the value of category
     *
     * @return CategoryEntity
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the value of category
     *
     * @param CategoryEntity $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Gets the value of lead
     *
     * @return AccountInterface
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * Sets the value of lead
     *
     * @param AccountInterface $lead
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
    }
}
