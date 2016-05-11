<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\InputFilter;

use Zend\InputFilter\InputFilter;

class Account extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'token',
            'required' => true,
        ]);

        $this->add([
            'name' => 'currentPassword',
            'required' => true,
            'filters' => [
                [
                    'name' => 'Zend\Filter\StringTrim',
                ],
            ],
        ]);

        $this->add([
            'name' => 'newPassword',
            'required' => true,
            'filters' => [
                [
                    'name' => 'Zend\Filter\StringTrim',
                ],
            ],
        ]);

        $this->add([
            'name' => 'confirmPassword',
            'required' => true,
            'filters' => [
                [
                    'name' => 'Zend\Filter\StringTrim',
                ],
            ],
            'validators' => [
                [
                    'name' => 'Identical',
                    'options' => [
                        'token' => 'newPassword',
                        'strict' => true,
                    ],
                ],
            ],
        ]);
    }
}
