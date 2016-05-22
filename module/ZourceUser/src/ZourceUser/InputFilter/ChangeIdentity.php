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
use ZourceUser\Validator\IdentityNotExists;

class ChangeIdentity extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'token',
            'required' => true,
        ]);

        $this->add([
            'name' => 'identity',
            'required' => true,
            'filters' => [
                [
                    'name' => 'Zend\\Filter\\StringTrim',
                ],
            ],
            'validators' => [
                [
                    'name' => IdentityNotExists::class,
                    'options' => [
                        'directory' => 'username',
                    ],
                ],
            ],
        ]);
    }
}
