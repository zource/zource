<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use ZourceUser\Entity\AccountInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_refresh_token")
 */
class OAuthRefreshToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @var string
     */
    private $refreshToken;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceUser\Entity\OAuthApplication", fetch="LAZY")
     * @ORM\JoinColumn(referencedColumnName="client_id", onDelete="CASCADE", nullable=false)
     * @var OAuthApplication
     */
    private $application;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceUser\Entity\AccountInterface", fetch="LAZY")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @var AccountInterface
     */
    private $account;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $expires;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     * @var string|null
     */
    private $scope;

    public function __construct($refreshToken, OAuthApplication $application, AccountInterface $account, $expires)
    {
        $this->refreshToken = $refreshToken;
        $this->application = $application;
        $this->account = $account;
        $this->expires = $expires;
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @return OAuthApplication
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @return AccountInterface
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return DateTime
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @return string|null
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param string|null $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }
}
