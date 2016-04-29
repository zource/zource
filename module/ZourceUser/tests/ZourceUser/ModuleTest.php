<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUserTest;

use PHPUnit_Framework_TestCase;
use ZourceUser\Module;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    public function testGetConfig()
    {
        // Arrange
        $module = new Module();

        // Act
        $result = $module->getConfig();

        // Assert
        $this->assertInternalType('array', $result);
    }
}
