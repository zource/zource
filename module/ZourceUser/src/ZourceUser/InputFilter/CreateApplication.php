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

class CreateApplication extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'token',
            'required' => true,
        ]);

        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                [
                    'name' => 'Zend\\Filter\\StringTrim',
                ],
                [
                    'name' => 'Zend\\Filter\\StripTags',
                ],
            ],
        ]);

        $this->add([
            'name' => 'description',
            'required' => false,
            'filters' => [
                [
                    'name' => 'Zend\\Filter\\StringTrim',
                ],
                [
                    'name' => 'Zend\\Filter\\StripTags',
                ],
            ],
        ]);

        $this->add([
            'name' => 'homepage',
            'required' => true,
            'filters' => [
                [
                    'name' => 'Zend\\Filter\\StringTrim',
                ],
                [
                    'name' => 'Zend\\Filter\\StripTags',
                ],
            ],
            'validators' => [
                [
                    'name' => 'Zend\\Validator\\Uri',
                    'options' => [
                        'allowRelative' => false,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'redirectUri',
            'required' => false,
            'filters' => [
                [
                    'name' => 'Zend\\Filter\\StringTrim',
                ],
                [
                    'name' => 'Zend\\Filter\\StripTags',
                ],
            ],
            'validators' => [
                [
                    'name' => 'Zend\\Validator\\Uri',
                    'options' => [
                        'allowRelative' => false,
                    ],
                ],
            ],
        ]);
    }
}
