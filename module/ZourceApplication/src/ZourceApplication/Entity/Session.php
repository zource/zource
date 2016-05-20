<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use ZourceUser\Entity\AccountInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="application_session")
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=32)
     * @var string
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ZourceUser\Entity\AccountInterface")
     * @var AccountInterface|null
     */
    private $account;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $data;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $creationDate;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $lastModified;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $lifetime;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $userAgent;

    /**
     * TODO: We can probably save the IP address in a more friendly way like an integer?
     * @ORM\Column(type="string", length=15)
     * @var string
     */
    private $remoteAddress;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $id The id of the session.
     * @param string $userAgent The user agent of the user.
     * @param string $remoteAddress The remote address of the user.
     */
    public function __construct($id, $userAgent, $remoteAddress)
    {
        $this->id = $id;
        $this->userAgent = $userAgent;
        $this->remoteAddress = $remoteAddress;

        $this->creationDate = new DateTime();
        $this->lastModified = new DateTime();
        $this->lifetime = 3600;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @return DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * @param DateTime $lastModified
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @param int $lifetime
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @return string
     */
    public function getRemoteAddress()
    {
        return $this->remoteAddress;
    }
}
