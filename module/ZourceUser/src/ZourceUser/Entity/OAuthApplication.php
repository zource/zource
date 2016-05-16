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
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use ZourceUser\V1\Rest\Account\AccountEntity as AccountInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_application")
 */
class OAuthApplication
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary")
     * @var UuidInterface
     */
    private $clientId;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     * @var string|null
     */
    private $clientSecret;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceUser\V1\Rest\Account\AccountEntity", fetch="EAGER")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @var AccountInterface|null
     */
    private $account;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTimeImmutable
     */
    private $createdOn;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $homepage;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    private $redirectUri;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $name
     * @param string $homepage
     */
    public function __construct($name, $homepage)
    {
        $this->clientId = Uuid::uuid4();
        $this->createdOn = new DateTimeImmutable('now');
        $this->name = $name;
        $this->homepage = $homepage;
    }

    /**
     * @return UuidInterface
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string|null
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param null|string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return AccountInterface|null
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param AccountInterface|null $account
     */
    public function setAccount(AccountInterface $account = null)
    {
        $this->account = $account;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return null|string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param null|string $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }
}
