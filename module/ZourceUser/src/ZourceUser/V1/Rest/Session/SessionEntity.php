<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\V1\Rest\Session;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_session")
 */
class SessionEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=32)
     * @var string
     */
    private $sessionId;

    /**
     * Initializes a new instance of this class.
     *
     * @param string $sessionId The session id.
     */
    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }
}