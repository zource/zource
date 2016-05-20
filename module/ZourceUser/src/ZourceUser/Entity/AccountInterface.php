<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Entity;

use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

/**
 * The interface that is implemented by accounts.
 */
interface AccountInterface
{
    /** The account is active. */
    const STATUS_ACTIVE = 0;

    /** The account is inactive. */
    const STATUS_INACTIVE = 1;

    /** Two-factor authentication using HMAC-based one-time password (OTP) algorithm. */
    const TFA_TYPE_HOTP = 'HOTP';

    /** Two-factor authentication using Time-based one-time password (OTP) algorithm. */
    const TFA_TYPE_TOTP = 'TOTP';

    /**
     * Gets the identifier of the account.
     *
     * @return UuidInterface
     */
    public function getId();

    /**
     * Gets the credential for this account.
     * This will be a hashed string.
     *
     * @return string
     */
    public function getCredential();

    /**
     * Gets the reset code used to reset the credential.
     * This will be null when no reset code has been set.
     *
     * @return null|string
     */
    public function getResetCredentialCode();

    /**
     * Gets the status of the account.
     *
     * @return int
     */
    public function getStatus();

    /**
     * Gets the Two-factor authentication method used for this account
     * This will be null when Two-factor authentication has not been set up.
     *
     * @return null|string
     */
    public function getTwoFactorAuthenticationType();

    /**
     * Gets the Two-factor authentication secret code used for this account
     * This will be null when Two-factor authentication has not been set up.
     *
     * @return null|string
     */
    public function getTwoFactorAuthenticationCode();

    /**
     * Checks if Two-Factor authentication is enabeld for this account.
     *
     * @return bool
     */
    public function hasTwoFactorAuthentication();

    /**
     * Gets the groups of this account.
     *
     * @return Collection
     */
    public function getGroups();

    /**
     * Gets the e-mail addresses for this account.
     *
     * @return Collection
     */
    public function getEmailAddresses();

    /**
     * Gets the display name for this account.
     *
     * @return string
     */
    public function getDisplayName();
}
