<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\GadgetType;

class GadgetTypeEntity
{
    public $id;
    public $title;
    public $description;
    public $category;
    public $thumbnail;

    public function __construct(array $item)
    {
        $this->id = $item['id'];
        $this->title = $item['title'];
        $this->description = $item['description'];
        $this->category = $item['category'];
        $this->thumbnail = $item['thumbnail'];
    }
}
