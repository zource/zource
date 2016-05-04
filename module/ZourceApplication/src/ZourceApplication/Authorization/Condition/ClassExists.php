<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Authorization\Condition;

use RuntimeException;

/**
 * A condition that checks if a certain class exists in code.
 */
class ClassExists extends AbstractCondition
{
    /**
     * @var string
     */
    private $fqcn;

    public function __construct($options)
    {
        if (!isset($options['fqcn'])) {
            throw new RuntimeException('Missing the "fqcn" option.');
        }

        $this->fqcn = $options['fqcn'];
    }

    public function isValid()
    {
        return class_exists($this->fqcn, false);
    }
}
