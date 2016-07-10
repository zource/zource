<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;
use Zend\Permissions\Rbac\RoleInterface;
use ZourceContact\Entity\Person;

/**
 * The interface that is implemented by accounts.
 */
interface AccountInterface
{
    /** The account is active. */
    const STATUS_ACTIVE = 1;

    /** The account is inactive. */
    const STATUS_INACTIVE = 0;

    /** The account is inactive. */
    const STATUS_INVITED = -1;

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
     * Gets the date and time of when the account was created.
     *
     * @return DateTime
     */
    public function getCreationDate();

    /**
     * @return Person
     */
    public function getContact();

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
     * Adds this account to the given group.
     *
     * @param Group $group
     */
    public function addGroup(Group $group);

    /**
     * Gets the groups of this account.
     *
     * @return Collection
     */
    public function getGroups();

    /**
     * Removes this account from the given group.
     *
     * @param Group $group
     * @return mixed
     */
    public function removeGroup(Group $group);

    /**
     * Sets the groups for this account.
     *
     * @param array|Collection $groups
     */
    public function setGroups($groups);

    /**
     * Gets the e-mail addresses for this account.
     *
     * @return Collection
     */
    public function getEmailAddresses();

    /**
     * Gets the property by the given name or returns the default value of it.
     *
     * @param string $name The name of the property to get.
     * @param string|null $defaultValue The default value to return.
     * @return string|null
     */
    public function getProperty($name, $defaultValue = null);

    /**
     * Sets the property by the given name.
     *
     * @param string $name The name of the property to set.
     * @param string|null $value The default value to set.
     */
    public function setProperty($name, $value);
}
