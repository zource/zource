<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\TaskService;

class CronManager
{
    const TMP_PATH = 'data/tmp/crontab.txt';

    public function getCronjobs()
    {
        return [];
    }

    public function persist()
    {
        $output = shell_exec('crontab -l');

        $newCron = '* * * * * NEW_CRON';

        file_put_contents(self::TMP_PATH, $output . $newCron . PHP_EOL);

        exec('crontab ' . self::TMP_PATH);
    }
}
