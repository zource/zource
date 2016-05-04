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

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_scope")
 */
class OAuthScope
{
    /**
     * @ORM\Id
     * @ORM\Column(name="type", type="string", length=255, options={"default": "supported"})
     * @var string
     */
    private $type;

    /**
     * @ORM\Column(name="scope", type="string", length=2000, nullable=true)
     * @var string
     */
    private $scope;

    /**
     * @ORM\Column(name="client_secret", type="string", length=80)
     * @var string
     */
    private $clientId;

    /**
     * @ORM\Column(name="is_default", type="boolean", nullable=true)
     * @var bool
     */
    private $isDefault;
}
