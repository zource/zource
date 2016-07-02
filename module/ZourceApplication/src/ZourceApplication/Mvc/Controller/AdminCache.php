<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceApplication\TaskService\CacheManager;

class AdminCache extends AbstractActionController
{
    /**
     * @var CacheManager
     */
    private $cacheManager;

    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function indexAction()
    {
        $cacheItems = $this->cacheManager->getCacheItems();

        return new ViewModel([
            'cacheItems' => $cacheItems,
        ]);
    }

    public function clearAction()
    {
        $id = $this->params('id');

        $this->cacheManager->clearCache($id);

        $this->flashMessenger()->addSuccessMessage('Cache has been cleared');

        return $this->redirect()->toRoute('admin/system/cache');
    }
}
