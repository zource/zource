<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Form;

use Zend\Form\Form as BaseForm;

class ResetPassword extends BaseForm
{
    public function init()
    {
        $this->add([
            'type' => 'Csrf',
            'name' => 'token',
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'code',
            'options' => [
                'label' => 'resetPasswordFormCode',
                'description' => 'resetPasswordFormCodeDesc',
            ],
        ]);

        $this->add([
            'type' => 'Password',
            'name' => 'credential',
            'options' => [
                'label' => 'resetPasswordFormCredential',
                'description' => 'resetPasswordFormCredentialDesc',
            ],
        ]);

        $this->add([
            'type' => 'Password',
            'name' => 'verification',
            'options' => [
                'label' => 'resetPasswordFormVerification',
                'description' => 'resetPasswordFormVerificationDesc',
            ],
        ]);

        $this->add([
            'type' => 'Submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'resetPasswordFormSubmit',
            ],
        ]);
    }
}
