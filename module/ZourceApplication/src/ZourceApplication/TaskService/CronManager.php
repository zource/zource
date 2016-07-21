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
use ZourceApplication\Entity\Cronjob;

class CronManager
{
    const TMP_PATH = 'data/tmp/crontab.txt';

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCronjobs()
    {
        $repository = $this->entityManager->getRepository(Cronjob::class);

        return $repository->findAll();
    }

    public function find($id)
    {
        $repository = $this->entityManager->getRepository(Cronjob::class);

        return $repository->find($id);
    }

    public function persistFromArray(array $data)
    {
        $cronjob = new Cronjob($data['name'], $data['pattern'], $data['command']);
        $cronjob->setActive($data['active']);

        $this->entityManager->persist($cronjob);
        $this->entityManager->flush($cronjob);

        $this->flushToSystem();
    }

    public function remove(Cronjob $cronjob)
    {
        $this->entityManager->remove($cronjob);
        $this->entityManager->flush($cronjob);

        $this->flushToSystem();
    }

    private function flushToSystem()
    {
        $crontabContent = '';

        /** @var Cronjob $cronjob */
        foreach ($this->getCronjobs() as $cronjob) {
            if ($cronjob->getActive()) {
                $crontabContent .= $cronjob->getPattern() . ' ' . $cronjob->getCommand() . PHP_EOL;
            }
        }

        file_put_contents(self::TMP_PATH, $crontabContent);

        exec('crontab -r');
        exec('crontab ' . self::TMP_PATH);
    }
}
