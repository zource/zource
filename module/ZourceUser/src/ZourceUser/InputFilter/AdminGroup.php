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

class AdminGroup extends InputFilter
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
                    'name' => 'Zend\Filter\StringTrim',
                ],
            ],
        ]);

        $this->add([
            'name' => 'description',
            'required' => false,
            'filters' => [
                [
                    'name' => 'Zend\Filter\StringTrim',
                ],
            ],
        ]);

        $this->add([
            'name' => 'accounts',
            'required' => false,
            'filters' => [
                [
                    'name' => 'Zend\Filter\StringTrim',
                ],
            ],
        ]);

        $this->add([
            'name' => 'permissions',
            'required' => false,
        ]);
    }
}
