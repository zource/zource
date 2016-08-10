<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Group;

use ZourceUser\Entity\Group;

class GroupEntity
{
    public $id;
    public $name;
    public $description;
    public $permissions;
    public $accounts;

    public function __construct(Group $group)
    {
        $this->id = $group->getId();
        $this->name = $group->getName();
        $this->description = $group->getDescription();
        $this->permissions = $group->getPermissions();
        $this->accounts = $this->extractAccounts($group);
    }

    private function extractAccounts($group)
    {
        $result = [];

        return $result;
    }
}
