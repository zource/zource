<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Validator;

use Zend\Validator\AbstractValidator;

class Directory extends AbstractValidator
{
    const INVALID_DIRECTORY = 'invalidDirectory';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID_DIRECTORY => 'Invalid directory provided, should be one of %validDirectories%.',
    ];

    protected $messageVariables = [
        'validDirectories' => 'validDirectories',
    ];

    /**
     * @var array
     */
    protected $directories;

    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->directories = $options['valid_directories'];
        $this->validDirectories = implode(', ', $this->directories);
    }

    /**
     * {@inheritDoc}
     */
    public function isValid($value)
    {
        if (!in_array($value, $this->directories)) {
            $this->error(self::INVALID_DIRECTORY);
            return false;
        }

        $this->setValue($value);

        return true;
    }
}
