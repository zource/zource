<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Paginator;

use Zend\Paginator\Adapter\AdapterInterface;
use Zend\Paginator\Adapter\Callback;
use Zend\Paginator\Paginator;

abstract class AbstractProxy extends Paginator
{
    /**
     * @var AdapterInterface
     */
    protected $proxy;

    public function __construct(AdapterInterface $adapter)
    {
        $this->proxy = $adapter;

        parent::__construct(new Callback(
            [$this, 'onGetItems'],
            [$this, 'onCount']
        ));
    }

    public function onCount()
    {
        return $this->proxy->count();
    }

    public function onGetItems($offset, $itemCountPerPage)
    {
        $result = [];

        foreach ($this->proxy->getItems($offset, $itemCountPerPage) as $key => $value) {
            $result[] = $this->build($key, $value);
        }

        return $result;
    }

    protected abstract function build($key, $value);
}
