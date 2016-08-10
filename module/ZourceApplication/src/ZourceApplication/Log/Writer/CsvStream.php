<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Log\Writer;

use Zend\Log\Writer\Stream;

final class CsvStream extends Stream
{
    protected function doWrite(array $event)
    {
        $data = [
            'timestamp' => $event['timestamp']->format('c'),
            'priority' => $event['priority'],
            'priorityName' => $event['priorityName'],
            'message' => $event['message'],
        ];

        if (array_key_exists('extra', $event)) {
            $data['extra'] = json_encode($event['extra'], JSON_UNESCAPED_SLASHES | JSON_BIGINT_AS_STRING);
        }

        fputcsv($this->stream, $data, ';');
    }
}
