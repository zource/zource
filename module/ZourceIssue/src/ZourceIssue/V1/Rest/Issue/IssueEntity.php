<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceIssue\V1\Rest\Issue;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use ZourceIssue\V1\Rest\IssueType\IssueTypeEntity;
use ZourceIssue\V1\Rest\Priority\PriorityEntity;
use ZourceIssue\V1\Rest\Resolution\ResolutionEntity;
use ZourceIssue\V1\Rest\Status\StatusEntity;
use ZourceProject\V1\Rest\Project\ProjectEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="issue")
 */
class IssueEntity
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
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    private $updatedDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    private $resolutionDate;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceProject\V1\Rest\Project\ProjectEntity")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     * @var ProjectEntity
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceIssue\V1\Rest\Status\StatusEntity")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var StatusEntity
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceIssue\V1\Rest\IssueType\IssueTypeEntity")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var IssueTypeEntity
     */
    private $type;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $issueKey;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    private $dueDate;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $summary;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceIssue\V1\Rest\Resolution\ResolutionEntity")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     * @var ResolutionEntity
     */
    private $resolution;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceIssue\V1\Rest\Priority\PriorityEntity")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     * @var PriorityEntity
     */
    private $priority;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }
}
