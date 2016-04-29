<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Validator;

use Ramsey\Uuid\Uuid as UuidImpl;
use Zend\Validator\AbstractValidator;

class Uuid extends AbstractValidator
{
    const INVALID_UUID = 'invalidUuid';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_UUID => 'Invalid UUID value given.',
    ];

    /**
     * {@inheritDoc}
     */
    public function isValid($value)
    {
        if (!UuidImpl::isValid($value)) {
            $this->error(self::INVALID_UUID);
            return false;
        }

        $this->setValue($value);

        return true;
    }
}
