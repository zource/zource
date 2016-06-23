<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_application_authorized")
 */
class OAuthAuthorizedApplication
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ZourceUser\Entity\AccountInterface", fetch="EAGER")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var AccountInterface
     */
    private $account;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ZourceUser\Entity\OAuthApplication", fetch="EAGER")
     * @ORM\JoinColumn(onDelete="CASCADE", referencedColumnName="client_id")
     * @var OAuthApplication
     */
    private $application;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTimeImmutable
     */
    private $createdOn;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     * @var string|null
     */
    private $scope;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct(AccountInterface $account, OAuthApplication $application, $scope)
    {
        $this->account = $account;
        $this->application = $application;
        $this->createdOn = new DateTimeImmutable('now');
        $this->scope = $scope;
    }

    /**
     * @return AccountInterface
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return OAuthApplication
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return null|string
     */
    public function getScope()
    {
        return $this->scope;
    }
}
