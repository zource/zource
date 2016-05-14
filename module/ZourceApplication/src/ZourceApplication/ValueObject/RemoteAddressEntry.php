<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\ValueObject;

class RemoteAddressEntry
{
    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $countryName;

    /**
     * @var string
     */
    private $regionName;

    /**
     * @var string
     */
    private $cityName;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $countryCode
     * @param string $countryName
     * @param string $regionName
     * @param string $cityName
     */
    public function __construct($countryCode, $countryName, $regionName, $cityName)
    {
        $this->countryCode = $countryCode;
        $this->countryName = $countryName;
        $this->regionName = $regionName;
        $this->cityName = $cityName;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @return string
     */
    public function getRegionName()
    {
        return $this->regionName;
    }

    /**
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    public function getLocation()
    {
        $location = [];

        if ($this->getCityName()) {
            $location[] = $this->getCityName();
        }

        if ($this->getRegionName()) {
            $location[] = $this->getRegionName();
        }

        if ($this->getCountryName()) {
            $location[] = $this->getCountryName();
        }

        return implode(', ', $location);
    }
}
