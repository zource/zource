<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\InputFilter;

use Zend\Filter\StringToLower;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Regex;

class InstallPlugin extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                [
                    'name' => StringToLower::class,
                ],
            ],
            'validators' => [
                [
                    'name' => Regex::class,
                    'options' => [
                        'pattern' => '/^[a-z0-9-_]+\/[a-z0-9-_]+/i',
                        'messages' => [
                            Regex::NOT_MATCH => 'Invalid package name provided.',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
