<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\Dashboard;

use ZourceApplication\Paginator\AbstractProxy;

class DashboardCollection extends AbstractProxy
{
    protected function build($key, $value)
    {
        return new DashboardEntity($value);
    }
}
