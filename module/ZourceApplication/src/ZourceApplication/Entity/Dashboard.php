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

class Dashboard
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var DateTimeInterface
     */
    private $creationDate;

    /**
     * @var DateTimeInterface
     */
    private $updateDate;

    /**
     * @var string
     */
    private $name;

    /**
     * @var WidgetContainer
     */
    private $widgetContainer;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->id = Uuid::uuid4();
        $this->creationDate = new DateTime();
        $this->updateDate = new DateTime();
        $this->name = $name;
        $this->widgetContainer = new WidgetContainer(WidgetContainer::LAYOUT_100);
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
    public function getCreationDate()
    {
        return $this->creationDate;
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return WidgetContainer
     */
    public function getWidgetContainer()
    {
        return $this->widgetContainer;
    }
}
