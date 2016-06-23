<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Entity;

use DateTimeInterface;

abstract class AbstractDate extends AbstractValue
{
    /**
     * @var DateTimeInterface
     */
    protected $value;

    public function __construct(AbstractContact $contact, $type, DateTimeInterface $value)
    {
        parent::__construct($contact, $type);

        $this->value = $value;
    }

    /**
     * @return DateTimeInterface
     */
    public function getValue()
    {
        return $this->value;
    }
}
