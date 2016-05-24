<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\ValueObject;

use Ramsey\Uuid\UuidInterface;

class ContactEntry
{
    const TYPE_PERSON = 'person';
    const TYPE_COMPANY = 'company';
    const TYPE_UNKNOWN = 'unknown';

    /**
     * @var string
     */
    private $type;

    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $displayName;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $type The type of contact.
     * @param UuidInterface $id The id of the contact.
     * @param string $displayName The display name to show.
     */
    public function __construct($type, UuidInterface $id, $displayName)
    {
        $this->type = $type;
        $this->id = $id;
        $this->displayName = $displayName;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }
}
