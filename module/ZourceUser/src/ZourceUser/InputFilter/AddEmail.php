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

class AddEmail extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'token',
            'required' => true,
        ]);

        $this->add([
            'name' => 'emailAddress',
            'required' => true,
            'filters' => [
                [
                    'name' => 'Zend\Filter\StringTrim',
                ],
            ],
            'validators' => [
                [
                    'name' => 'Zend\\Validator\\EmailAddress',
                ],
            ],
        ]);
    }
}
