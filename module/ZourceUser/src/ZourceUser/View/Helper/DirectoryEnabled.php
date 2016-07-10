<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\View\Helper;

use Zend\View\Helper\AbstractHelper;
use ZourceUser\Authentication\AuthenticationService;
use ZourceUser\TaskService\Directory;

class DirectoryEnabled extends AbstractHelper
{
    /**
     * @var Directory
     */
    private $directoryTaskService;

    public function __construct(Directory $directoryTaskService)
    {
        $this->directoryTaskService = $directoryTaskService;
    }

    public function __invoke($name)
    {
        $directory = $this->directoryTaskService->getDirectory($name);

        return $directory['enabled'];
    }
}
