<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Entity;

use DateTime;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractValue
{
    /**
     * @var UuidInterface
     */
    protected $id;

    /**
     * @var AbstractContact
     */
    protected $contact;

    /**
     * @var DateTimeInterface
     */
    protected $creationDate;

    /**
     * @var string
     */
    protected $type;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $type The type.
     */
    public function __construct(AbstractContact $contact, $type)
    {
        $this->id = Uuid::uuid4();
        $this->contact = $contact;
        $this->creationDate = new DateTime();
        $this->type = $type;
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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
