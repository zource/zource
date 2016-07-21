<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\InputFilter;

use Zend\Filter\StringTrim;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Digits;

class Cronjob extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                [
                    'name' => StringTrim::class,
                ],
            ],
        ]);

        $this->add([
            'name' => 'pattern',
            'required' => true,
            'filters' => [
                [
                    'name' => StringTrim::class,
                ],
            ],
        ]);

        $this->add([
            'name' => 'command',
            'required' => true,
            'filters' => [
                [
                    'name' => StringTrim::class,
                ],
            ],
        ]);

        $this->add([
            'name' => 'active',
            'required' => true,
            'filters' => [
                [
                    'name' => StringTrim::class,
                ],
            ],
        ]);
    }
}
