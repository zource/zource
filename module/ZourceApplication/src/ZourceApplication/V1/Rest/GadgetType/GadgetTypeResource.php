<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\GadgetType;

use Zend\Paginator\Adapter\ArrayAdapter;
use ZF\Rest\AbstractResourceListener;

class GadgetTypeResource extends AbstractResourceListener
{
    /**
     * @var array
     */
    private $config;

    /**
     * Initializes a new instance of this class.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function fetch($id)
    {
        if (!array_key_exists($id, $this->config)) {
            return null;
        }

        $this->config[$id]['id'] = $id;

        return new GadgetTypeEntity($this->config[$id]);
    }

    public function fetchAll($params = array())
    {
        $adapter = new ArrayAdapter($this->config);

        return new GadgetTypeCollection($adapter);
    }
}
