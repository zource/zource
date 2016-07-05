<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Bytes extends AbstractHelper
{
    public function __invoke($bytes)
    {
        if ($bytes >= 1073741824) {
            $fileSize = round($bytes / 1024 / 1024 / 1024, 1) . ' gB';
        } elseif ($bytes >= 1048576) {
            $fileSize = round($bytes / 1024 / 1024, 1) . ' mB';
        } elseif ($bytes >= 1024) {
            $fileSize = round($bytes / 1024, 1) . ' kB';
        } else {
            $fileSize = $bytes . ' bytes';
        }

        return $fileSize;
    }
}
