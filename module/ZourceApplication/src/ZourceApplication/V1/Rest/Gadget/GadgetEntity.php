<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\Gadget;

use ZourceApplication\Entity\Gadget;
use ZourceApplication\V1\Rest\GadgetContainer\GadgetContainerEntity;

class GadgetEntity
{
    public $id;
    public $installationDate;
    public $updateDate;
    public $gadgetContainer;
    public $gadgetType;
    public $options;
    public $column;
    public $position;

    public function __construct(Gadget $item)
    {
        $this->id = $item->getId();
        $this->installationDate = $item->getInstallationDate();
        $this->updateDate = $item->getUpdateDate();
        $this->gadgetContainer = $item->getGadgetContainer()->getId();
        $this->gadgetType = $item->getGadgetType();
        $this->options = $item->getOptions();
        $this->column = $item->getColumn();
        $this->position = $item->getPosition();
    }
}
