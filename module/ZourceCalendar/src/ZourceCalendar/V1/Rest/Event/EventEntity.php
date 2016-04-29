<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceCalendar\V1\Rest\Event;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="calendar_event")
 */
class EventEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary")
     * @var UuidInterface
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $name;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $name The name of the event.
     */
    public function __construct($name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
    }
}
