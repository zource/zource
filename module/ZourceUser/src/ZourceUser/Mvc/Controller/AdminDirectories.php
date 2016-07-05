<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceUser\ValueObject\Directory;

class AdminDirectories extends AbstractActionController
{
    public function indexAction()
    {
        $config = $this->getServiceLocator()->get('Config');

        $directories = [];
        foreach ($config['zource_auth_directories'] as $type => $options) {
            $directory = new Directory($type, $options['label'], true);

            if (array_key_exists('update_route_name', $options)) {
                $directory->setUpdateRouteName($options['update_route_name']);
            }

            if (array_key_exists('update_route_params', $options)) {
                $directory->setUpdateRouteParams($options['update_route_params']);
            }

            if (array_key_exists('update_route_options', $options)) {
                $directory->setUpdateRouteOptions($options['update_route_options']);
            }

            $directories[] = $directory;
        }

        return new ViewModel([
            'directories' => $directories,
        ]);
    }
}
