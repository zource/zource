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

class Widget
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
     * @var WidgetContainer
     */
    private $widgetContainer;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $options;

    /**
     * @var int
     */
    private $column;

    /**
     * @var int
     */
    private $position;

    /**
     * Initializes a new instance of this class.
     *
     * @param WidgetContainer $widgetContainer
     * @param string $type
     * @param array $options
     */
    public function __construct(WidgetContainer $widgetContainer, $type, array $options = [])
    {
        $this->id = Uuid::uuid4();
        $this->installationDate = new DateTime();
        $this->updateDate = new DateTime();
        $this->widgetContainer = $widgetContainer;
        $this->type = $type;
        $this->options = $options;
        $this->column = 0;
        $this->position = 0;
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
     * @return WidgetContainer
     */
    public function getWidgetContainer()
    {
        return $this->widgetContainer;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return int
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param int $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}
