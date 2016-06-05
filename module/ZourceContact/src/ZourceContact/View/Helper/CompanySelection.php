<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CompanySelection extends AbstractHelper
{
    public function __invoke()
    {
        return '<input type="text">';
    }
}
