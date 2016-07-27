<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Directory;

use Zend\Paginator\Adapter\ArrayAdapter;
use ZF\Rest\AbstractResourceListener;

class DirectoryResource extends AbstractResourceListener
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function fetch($id)
    {
        if (!array_key_exists($id, $this->config)) {
            return null;
        }

        $data = $this->config[$id];
        $data['id'] = $id;

        return new DirectoryEntity($data);
    }

    public function fetchAll($params = [])
    {
        $adapter = new ArrayAdapter($this->config);

        return new DirectoryCollection($adapter);
    }
}
