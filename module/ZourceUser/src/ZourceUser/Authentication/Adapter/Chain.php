<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Authentication\Adapter;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Adapter\ValidatableAdapterInterface;
use Zend\Authentication\Result;

class Chain extends AbstractAdapter
{
    /**
     * @var AdapterInterface[]
     */
    private $adapters;

    public function __construct(array $adapters = [])
    {
        $this->adapters = [];

        foreach ($adapters as $adapter) {
            $this->addAdapter($adapter);
        }
    }

    public function addAdapter(AdapterInterface $adapter)
    {
        $this->adapters[] = $adapter;
    }

    public function authenticate()
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter instanceof ValidatableAdapterInterface) {
                $adapter->setCredential($this->getCredential());
                $adapter->setIdentity($this->getIdentity());
            }
            
            $result = $adapter->authenticate();

            if ($result->getCode() === Result::SUCCESS) {
                return $result;
            }
        }

        return $result;
    }
}
