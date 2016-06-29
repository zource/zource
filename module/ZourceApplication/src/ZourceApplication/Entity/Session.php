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
use Gedmo\Mapping\Annotation as Gedmo;
use ZourceUser\Entity\AccountInterface;

class Session
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var AccountInterface|null
     */
    private $account;

    /**
     * @var string
     */
    private $data;

    /**
     * @var DateTime
     */
    private $creationDate;

    /**
     * @var DateTime
     */
    private $lastModified;

    /**
     * @var int
     */
    private $lifetime;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * TODO: We can probably save the IP address in a more friendly way like an integer?
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
