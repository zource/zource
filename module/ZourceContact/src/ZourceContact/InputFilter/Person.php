<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\InputFilter;

use Zend\InputFilter\InputFilter as BsaeInputFilter;

class Person extends BsaeInputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'name',
            'required' => true,
        ]);

        $this->add([
            'name' => 'middleName',
            'required' => false,
        ]);

        $this->add([
            'name' => 'familyName',
            'required' => true,
        ]);
    }
}
