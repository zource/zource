<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Paginator\Adapter;

use Zend\Paginator\Adapter\AdapterInterface;

final class CsvStream implements AdapterInterface
{
    private $path;
    private $lineCount;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function count()
    {
        if ($this->lineCount !== null) {
            return $this->lineCount;
        }

        $this->lineCount = 0;
        $stream = fopen($this->path, 'r');

        while (!feof($stream)) {
            $line = fgets($stream);

            if ($line) {
                $this->lineCount++;
            }
        }

        fclose($stream);

        return $this->lineCount;
    }

    public function getItems($offset, $itemCountPerPage)
    {
        $index = 0;
        $result = [];

        $stream = fopen($this->path, 'r');

        while (!feof($stream)) {
            $line = fgetcsv($stream, null, ';');
            if (!$line) {
                break;
            }

            if ($index >= $offset && $index < $offset + $itemCountPerPage) {
                $result[] = $line;
            }

            ++$index;
        }

        fclose($stream);

        return $result;
    }
}
