<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser;

use Zend\Console\Console;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;
use ZF\Apigility\Provider\ApigilityProviderInterface;
use ZourceUser\Authentication\Adapter\Service\PluginManager;
use ZourceUser\Listener\IdentityGuard;
use ZourceUser\Listener\RouteGuard;
use ZourceUser\Listener\Session;
use ZourceUser\V1\Rest\Account\AccountEntity;

class Module implements ApigilityProviderInterface
{
    public function init(ModuleManager $moduleManager)
    {
        $sm = $moduleManager->getEvent()->getParam('ServiceManager');

        $serviceListener = $sm->get('ServiceListener');
        $serviceListener->addServiceManager(
            PluginManager::class,
            'zource_auth_adapters',
            '',
            ''
        );
    }

    public function getConfig()
    {
        return ArrayUtils::merge(
            include __DIR__ . '/../../config/module.config.php',
            include __DIR__ . '/../../config/zource.config.php'
        );
    }

    public function getConsoleUsage()
    {
        return [
            'zource:account:create [--first-name=] [--family-name=] [--credential=]' => 'Creates a new account',
            ['--first-name=', 'The first name of the person that owns the account.'],
            ['--last-name=', 'The last name of the person that owns the account.'],
            ['--credential=', 'The plain text credential to set.'],

            'zource:account:delete <id>' => 'Deletes the account with the given id',
            ['id', 'The UUID of the account to delete.'],

            'zource:account:list' => 'Displays an overview of all accounts.',

            'zource:group:create [--name=]' => 'Creates a new group',
            ['--name=', 'The name of the group to create.'],

            'zource:group:delete <id>' => 'Deletes the group with the given id',
            ['id', 'The UUID of the group to delete.'],

            'zource:group:list' => 'Displays an overview of all groups.',

            'zource:group:permission [allow|deny] [--permission=] <id>' => 'Allows or denies permissions for a group.',
            ['id', 'The UUID of the group.'],

            'zource:group:member [--add=] [--remove=] <id>' => 'Adds a member to- or removes a member from the group.',
            ['--add=', 'Adds the provided UUID of the account to the group.'],
            ['--remove=', 'Removes the provided UUID of the account from the group.'],
            ['id', 'The UUID of the group .'],

            'zource:identity:create <account> <directory> <identity>' => 'Creates a new identity for the given account.',
            ['account', 'The UUID of the account to create the identity for.'],
            ['directory', 'The name of the directory to create the identity in.'],
            ['identity', 'The identity to create.'],

            'zource:identity:delete <id>' => 'Deletes the account with the given id',
            ['id', 'The UUID of the identity to delete.'],
        ];
    }

    public function onBootstrap(MvcEvent $e)
    {
        if (Console::isConsole()) {
            return;
        }

        $eventManager = $e->getApplication()->getEventManager();

        $guard = new IdentityGuard();
        $guard->attach($eventManager);

        $guard = new RouteGuard();
        $guard->attach($eventManager);

        $session = new Session();
        $session->attach($eventManager);

        $services = $e->getApplication()->getServiceManager();

        $hal = $services->get('ViewHelperManager')->get('Hal');
        $hal->getEventManager()->attach('renderEntity', [$this, 'onRenderEntity']);
    }

    public function onRenderEntity($e)
    {
        $entity = $e->getParam('entity');

        if (!$entity->entity instanceof AccountEntity) {
            return;
        }

        return;
        var_dump($entity->entity->getContact());
        exit;

        $entity->getLinks()->add(\ZF\Hal\Link\Link::factory(array(
            'rel' => 'contact',
            'route' => array(
                'name' => 'my/api/docs',
            ),
        )));
    }
}
