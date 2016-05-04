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
use ZourceUser\V1\Rest\Account\AccountEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_access_token")
 */
class OAuthAccessToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @var string
     */
    private $accessToken;
    
    /**
     * @ORM\ManyToOne(targetEntity="ZourceUser\Entity\OAuthApplication", fetch="LAZY")
     * @ORM\JoinColumn(referencedColumnName="client_id", onDelete="CASCADE", nullable=false)
     * @var OAuthApplication
     */
    private $application;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceUser\V1\Rest\Account\AccountEntity", fetch="LAZY")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     * @var AccountEntity
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

    public function __construct($accessToken, OAuthApplication $application, AccountEntity $account, $expires)
    {
        $this->accessToken = $accessToken;
        $this->application = $application;
        $this->account = $account;
        $this->expires = $expires;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return OAuthApplication
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @return AccountEntity
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
     * @param null|string $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }
}
