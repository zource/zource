<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\UI\Navigation\Item\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceApplication\Authorization\Condition\Service\PluginManager as ConditionPluginManager;

class ItemAbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return strpos($requestedName, 'ZourceApplication\\UI\\Navigation\\Item\\') === 0;
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $conditionManager = $serviceLocator->getServiceLocator()->get(ConditionPluginManager::class);
        $view = $serviceLocator->getServiceLocator()->get('ViewRenderer');

        return new $requestedName($conditionManager, $view);
    }
}
