<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\V1\Rest\Cache;

class CacheEntity
{
    /**
     * The id of cache.
     *
     * @var string
     */
    public $id;

    /**
     * The label describing the cache.
     *
     * @var string
     */
    public $label;

    /**
     * The size of cache in bytes.
     *
     * @var int
     */
    public $size;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->label = $data['label'];
        $this->size= $data['size'];
    }
}
