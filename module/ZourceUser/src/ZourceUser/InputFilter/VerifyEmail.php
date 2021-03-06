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
use ZourceUser\Validator\VerifyEmailCode;

class VerifyEmail extends InputFilter
{
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
                    'name' => VerifyEmailCode::class,
                ],
            ],
        ]);
    }
}
