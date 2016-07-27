<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\V1\Rest\Contact;

use ZourceContact\TaskService\Contact;

class ContactResourceFactory
{
    public function __invoke($services)
    {
        $contactTaskService = $services->get(Contact::class);

        return new ContactResource($contactTaskService);
    }
}
