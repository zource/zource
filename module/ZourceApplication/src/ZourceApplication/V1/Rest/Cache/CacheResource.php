<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\Cache;

use Zend\Paginator\Adapter\ArrayAdapter;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use ZourceApplication\TaskService\CacheManager;

class CacheResource extends AbstractResourceListener
{
    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * Initializes a new instance of this class.
     *
     * @param CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function delete($id)
    {
        $this->cacheManager->clearCache($id);

        return true;
    }

    public function deleteList($data)
    {
        $this->cacheManager->clearAllCache();

        return true;
    }

    public function fetch($id)
    {
        $cache = $this->cacheManager->getCacheItem($id);
        if (!$cache) {
            return null;
        }

        return new CacheEntity($cache);
    }

    public function fetchAll($params = array())
    {
        $adapter = new ArrayAdapter($this->cacheManager->getCacheItems());

        return new CacheCollection($adapter);
    }
}
