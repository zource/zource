<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\TaskService;

use Zend\EventManager\Event;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManager;

class CacheManager
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var EventManager
     */
    private $eventManager;

    public function __construct(array $config)
    {
        $this->config = $config;

        $this->eventManager = new EventManager([
            'CacheManager',
        ]);

        $this->eventManager->attach('clear', [$this, 'onClearCache']);
    }

    /**
     * @return EventManager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function getCacheItems()
    {
        $cacheItems = [];

        foreach ($this->config['items'] as $id => $item) {
            $data = [
                'id' => $id,
                'label' => $item['label'],
                'size' => 0,
            ];

            if ($item['type'] === 'file') {
                $data['size'] = $this->getFileSize($item['options']['path']);
            }

            $cacheItems[] = $data;
        }

        return $cacheItems;
    }

    public function clearCache($id)
    {
        $event = new Event();
        $event->setParam('id', $id);

        $result = $this->getEventManager()->trigger('clear', $event);

        return $result->last();
    }

    private function getFileSize($path)
    {
        if (!is_file($path)) {
            return 0;
        }

        return filesize($path);
    }

    public function onClearCache(EventInterface $event)
    {
        $id = $event->getParam('id');

        if (!array_key_exists($id, $this->config['items'])) {
            return false;
        }

        $item = $this->config['items'][$id];

        switch ($item['type']) {
            case 'file':
                if (is_file($item['options']['path'])) {
                    unlink($item['options']['path']);
                }
                break;

            default:
                // Non supported cache type, maybe a different listener will pick this up.
                return false;
        }

        return true;
    }
}
