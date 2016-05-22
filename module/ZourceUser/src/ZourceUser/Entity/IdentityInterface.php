<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

interface IdentityInterface
{
    /**
     * Gets the id of the identity.
     *
     * @return UuidInterface
     */
    public function getId();

    /**
     * Gets the account for this identity.
     *
     * @return AccountInterface
     */
    public function getAccount();

    /**
     * Gets the directory in which this identity resides.
     *
     * @return string
     */
    public function getDirectory();

    /**
     * Gets the identity value.
     *
     * @return string
     */
    public function getIdentity();
}
