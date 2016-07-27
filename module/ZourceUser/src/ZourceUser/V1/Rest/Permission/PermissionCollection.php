<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Permission;

use ZourceApplication\Paginator\AbstractProxy;

class PermissionCollection extends AbstractProxy
{
    protected function build($key, $value)
    {
        $entity = new PermissionEntity();
        $entity->id = $key;
        $entity->description = $value;

        return $entity;
    }
}
