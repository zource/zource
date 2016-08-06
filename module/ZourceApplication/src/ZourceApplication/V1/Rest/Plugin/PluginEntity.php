<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\Plugin;

use DateTimeInterface;
use ZourceApplication\Entity\Plugin;

class PluginEntity
{
    /**
     * The id of the plugin.
     *
     * @var string
     */
    public $id;

    /**
     * The installation date of the plugin.
     *
     * @var DateTimeInterface
     */
    public $installationDate;

    /**
     * The name of the plugin.
     *
     * @var string
     */
    public $name;

    /**
     * The description of the plugin.
     *
     * @var string
     */
    public $description;

    /**
     * A flag indicating whether or not the plugin is active.
     *
     * @var bool
     */
    public $active;

    public function __construct(Plugin $data)
    {
        $this->id = $data->getId();
        $this->installationDate = $data->getInstallationDate();
        $this->name = $data->getName();
        $this->description = $data->getDescription();
        $this->active = $data->getActive();
    }
}
