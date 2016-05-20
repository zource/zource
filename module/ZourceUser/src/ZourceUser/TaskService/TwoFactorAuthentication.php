<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\TaskService;

use Base32\Base32;
use Doctrine\ORM\EntityManager;
use Zend\Math\Rand;
use Zend\Session\Container;
use ZourceUser\Entity\AccountInterface;

class TwoFactorAuthentication
{
    const OTP_HOTP = 'HOTP';
    const OTP_TOTP = 'TOTP';

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Container
     */
    private $session;

    public function __construct(EntityManager $entityManager, Container $session)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
    }

    public function getSecret()
    {
        // We don't want to use the secret code of a previously logged in user.
        if (!$this->session->code || $this->session->id !== session_id()) {
            $this->session->id = session_id();
            $this->session->code = $this->createSecret();
        }

        return $this->session->code;
    }

    public function createSecret($secretLength = 16)
    {
        $secret = Rand::getString($secretLength, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567=');

        return $secret;
    }

    public function clearSecret()
    {
        $this->session->id = null;
        $this->session->code = null;
    }

    public function persistTwoFactorAuthentication(AccountInterface $account, $secret)
    {
        $account->setTwoFactorAuthenticationType(self::OTP_TOTP);
        $account->setTwoFactorAuthenticationCode($secret);

        $this->entityManager->persist($account);
        $this->entityManager->flush($account);
    }

    public function clearTwoFactorAuthentication(AccountInterface $account)
    {
        $account->setTwoFactorAuthenticationType(null);
        $account->setTwoFactorAuthenticationCode(null);

        $this->entityManager->persist($account);
        $this->entityManager->flush($account);
    }
}
