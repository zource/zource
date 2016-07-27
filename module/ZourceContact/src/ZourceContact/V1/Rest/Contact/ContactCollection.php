<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\V1\Rest\Contact;

use ZourceApplication\Paginator\AbstractProxy;
use ZourceContact\TaskService\Contact;

class ContactCollection extends AbstractProxy
{
    private $contactTaskService;

    public function __construct(Contact $contactTaskService)
    {
        $this->contactTaskService = $contactTaskService;

        $paginator = $this->contactTaskService->getOverviewPaginator(null);

        parent::__construct($paginator->getAdapter());
    }

    protected function build($key, $value)
    {
        return $this->contactTaskService->populateApiArray($value);
    }
}
