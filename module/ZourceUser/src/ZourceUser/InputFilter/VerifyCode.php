<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\InputFilter;

use OTPHP\HOTP;
use OTPHP\TOTP;
use RuntimeException;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Callback;
use ZourceUser\TaskService\TwoFactorAuthentication;
use ZourceUser\Validator\OneTimePassword;

class VerifyCode extends InputFilter
{
    private $oneTimePasswordType;
    private $oneTimePasswordCode;

    public function init()
    {
        $this->add([
            'name' => 'token',
            'required' => true,
        ]);

        $this->add([
            'name' => 'code',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Zend\\Validator\\Digits',
                    'break_chain_on_failure' => true,
                ],
                [
                    'name' => 'Zend\\Validator\\StringLength',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'min' => 6,
                        'max' => 6,
                    ],
                ],
                [
                    'name' => 'Zend\\Validator\\Callback',
                    'break_chain_on_failure' => true,
                    'options' => [
                        'callback' => [$this, 'onValidateOneTimePassword'],
                        'messages' => [
                            Callback::INVALID_VALUE => 'verifyCodeInputFilterCodeMessage',
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @return string
     */
    public function getOneTimePasswordType()
    {
        return $this->oneTimePasswordType;
    }

    /**
     * @param string $oneTimePasswordType
     */
    public function setOneTimePasswordType($oneTimePasswordType)
    {
        $this->oneTimePasswordType = $oneTimePasswordType;
    }

    /**
     * @return string
     */
    public function getOneTimePasswordCode()
    {
        return $this->oneTimePasswordCode;
    }

    /**
     * @param string $oneTimePasswordCode
     */
    public function setOneTimePasswordCode($oneTimePasswordCode)
    {
        $this->oneTimePasswordCode = $oneTimePasswordCode;
    }

    public function onValidateOneTimePassword($value)
    {
        switch ($this->oneTimePasswordType) {
            case TwoFactorAuthentication::OTP_HOTP:
                $oneTimePassword = new HOTP('', $this->getOneTimePasswordCode());
                break;

            case TwoFactorAuthentication::OTP_TOTP:
                $oneTimePassword = new TOTP('', $this->getOneTimePasswordCode());
                break;

            default:
                throw new RuntimeException('No valid OTP type set: ' . $this->oneTimePasswordType);
        }

        return $oneTimePassword->verify($value);
    }
}
