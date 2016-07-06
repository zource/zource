<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\ValueObject;

class Directory
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $label;

    /**
     * @var boolean
     */
    private $enabled;

    /**
     * @var string
     */
    private $updateRouteName;

    /**
     * @var array
     */
    private $updateRouteParams;

    /**
     * @var array
     */
    private $updateRouteOptions;

    /**
     * The name of the service used authenticate a user.
     *
     * @var string
     */
    private $serviceName;

    /**
     * Options passed to creating the service.
     *
     * @var array
     */
    private $serviceOptions;

    public function __construct($type, $label, $serviceName)
    {
        $this->type = $type;
        $this->label = $label;
        $this->enabled = false;
        $this->updateRouteParams = [];
        $this->updateRouteOptions = [];
        $this->serviceName = $serviceName;
        $this->serviceOptions = [];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function getUpdateRouteName()
    {
        return $this->updateRouteName;
    }

    /**
     * @param string $updateRouteName
     */
    public function setUpdateRouteName($updateRouteName)
    {
        $this->updateRouteName = $updateRouteName;
    }

    /**
     * @return array
     */
    public function getUpdateRouteParams()
    {
        return $this->updateRouteParams;
    }

    /**
     * @param array $updateRouteParams
     */
    public function setUpdateRouteParams($updateRouteParams)
    {
        $this->updateRouteParams = $updateRouteParams;
    }

    /**
     * @return array
     */
    public function getUpdateRouteOptions()
    {
        return $this->updateRouteOptions;
    }

    /**
     * @param array $updateRouteOptions
     */
    public function setUpdateRouteOptions($updateRouteOptions)
    {
        $this->updateRouteOptions = $updateRouteOptions;
    }

    /**
     * @return string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @param string $serviceName
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }

    /**
     * @return array
     */
    public function getServiceOptions()
    {
        return $this->serviceOptions;
    }

    /**
     * @param array $serviceOptions
     */
    public function setServiceOptions($serviceOptions)
    {
        $this->serviceOptions = $serviceOptions;
    }
}
