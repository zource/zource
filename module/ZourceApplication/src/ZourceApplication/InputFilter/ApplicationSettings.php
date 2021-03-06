<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\InputFilter;

use Zend\InputFilter\InputFilter;

class ApplicationSettings extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'application_title',
            'required' => true,
        ]);
    }
}
