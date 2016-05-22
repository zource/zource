<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Authorization\Condition;

use Zend\Authentication\AuthenticationService;
use ZourceApplication\Authorization\Condition\AbstractCondition;

/**
 * A condition that checks if any notifications are configured.
 */
class NotificationsExist extends AbstractCondition
{
    /**
     * @var Config
     */
    private $nofications;

    public function __construct(array $nofications)
    {
        $this->nofications = $nofications;
    }

    public function isValid()
    {
        return count($this->nofications)  !== 0;
    }
}
