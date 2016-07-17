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

class Gadget
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
     * @var GadgetContainer
     */
    private $gadgetContainer;

    /**
     * @var string
     */
    private $gadgetType;

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
     * @param GadgetContainer $gadgetContainer
     * @param string $gadgetType
     * @param array $options
     */
    public function __construct(GadgetContainer $gadgetContainer, $gadgetType, array $options = [])
    {
        $this->id = Uuid::uuid4();
        $this->installationDate = new DateTime();
        $this->updateDate = new DateTime();
        $this->gadgetContainer = $gadgetContainer;
        $this->gadgetType = $gadgetType;
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
     * @return GadgetContainer
     */
    public function getGadgetContainer()
    {
        return $this->gadgetContainer;
    }

    /**
     * @return string
     */
    public function getGadgetType()
    {
        return $this->gadgetType;
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
