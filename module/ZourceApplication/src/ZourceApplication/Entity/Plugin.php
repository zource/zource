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
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Plugin
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var DateTimeInterface
     */
    private $installationDate;

    /**
     * @var DateTimeInterface
     */
    private $updateDate;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $version;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $name
     * @param string $version
     */
    public function __construct($name, $version)
    {
        $this->id = Uuid::uuid4();
        $this->installationDate = new DateTime();
        $this->updateDate = new DateTime();
        $this->name = $name;
        $this->version = $version;
    }

    /**
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTimeInterface
     */
    public function getInstallationDate()
    {
        return $this->installationDate;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }
}
