<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\View\Helper\UI\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZourceApplication\Authorization\Condition\Service\PluginManager as ConditionPluginManager;
use ZourceApplication\UI\Navigation\Item\Service\PluginManager;
use ZourceApplication\View\Helper\UI\Nav;

class NavFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var PluginManager $itemManager */
        $itemManager = $serviceLocator->getServiceLocator()->get(PluginManager::class);

        /** @var ConditionPluginManager $conditionManager */
        $conditionManager = $serviceLocator->getServiceLocator()->get(ConditionPluginManager::class);

        /** @var array $config */
        $config = $serviceLocator->getServiceLocator()->get('Config');

        return new Nav($itemManager, $conditionManager, $config['zource_nav']);
    }
}
