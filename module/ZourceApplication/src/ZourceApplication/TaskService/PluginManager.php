<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\TaskService;

use Doctrine\ORM\EntityManager;
use RuntimeException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessUtils;
use ZourceApplication\Entity\Plugin;

class PluginManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getPluginByName($name)
    {
        $repository = $this->entityManager->getRepository(Plugin::class);

        return $repository->findOneBy([
            'name' => $name,
        ]);
    }

    public function getPlugin($id)
    {
        $repository = $this->entityManager->getRepository(Plugin::class);

        return $repository->find($id);
    }

    public function getPlugins()
    {
        $repository = $this->entityManager->getRepository(Plugin::class);

        return $repository->findAll();
    }

    public function install($name)
    {
        $plugin = $this->getPluginByName($name);
        if ($plugin) {
            return;
        }

        $process = $this->getProcess(
            sprintf(
                'composer require --no-progress --sort-packages --prefer-dist %s',
                ProcessUtils::escapeArgument($name)
            )
        );
        $process->start();
        $process->wait();

        if (strpos($process->getErrorOutput(), 'Nothing to install or update') !== false) {
            $info = $this->parsePluginInfo($name);
        } elseif (strpos($process->getErrorOutput(), 'Updating dependencies') !== false) {
            $info = $this->parsePluginInfo($name);
        } elseif (strpos($process->getErrorOutput(), 'Could not find package asd at any version for your minimum-stability') !== false) {
            throw new RuntimeException(sprintf('Package "%s" not found', $name));
        } else {
            throw new RuntimeException(sprintf('Unhandled output for package "%s"', $name));
        }

        $plugin = new Plugin($name, $info['version']);
        $plugin->setDescription($info['description']);

        $this->entityManager->persist($plugin);
        $this->entityManager->flush($plugin);
    }

    public function uninstall(Plugin $plugin)
    {
        $process = $this->getProcess(
            sprintf(
                'composer remove --no-progress %s',
                ProcessUtils::escapeArgument($plugin->getName())
            )
        );
        $process->start();
        $process->wait();

        $this->entityManager->remove($plugin);
        $this->entityManager->flush($plugin);
    }

    public function update(Plugin $plugin)
    {
        $process = $this->getProcess(
            sprintf(
                'composer update --no-progress %s',
                ProcessUtils::escapeArgument($plugin->getName())
            )
        );
        $process->start();
        $process->wait();

        $package = $this->parsePluginInfo($plugin->getName());

        $plugin->setVersion($package['version']);

        $this->entityManager->persist($plugin);
        $this->entityManager->flush($plugin);
    }

    private function parsePluginInfo($name)
    {
        $data = json_decode(file_get_contents('composer.lock'), true);

        foreach ($data['packages'] as $package) {
            if ($package['name'] === $name) {
                return $package;
            }
        }

        return null;
    }

    private function getProcess($cmd)
    {
        return new Process($cmd, getcwd(), [
            'COMPOSER_DISABLE_XDEBUG_WARN' => '1',
            'COMPOSER_NO_INTERACTION' => '1',
            'COMPOSER_CACHE_DIR' => 'data/cache/composer/',
            'COMPOSER_HOME' => 'data/cache/composer/',
        ]);
    }
}
