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

class Authenticate extends BaseForm
{
    public function init()
    {
        $this->add([
            'type' => 'Csrf',
            'name' => 'token',
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'identity',
            'options' => [
                'label' => 'loginFormInputIdentityLabel',
                'description' => 'loginFormInputIdentityTooltip',
            ],
        ]);

        $this->add([
            'type' => 'Password',
            'name' => 'credential',
            'options' => [
                'label' => 'loginFormInputCredentialLabel',
                'description' => 'loginFormInputCredentialTooltip',
            ],
        ]);

        $this->add([
            'type' => 'Submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'loginFormInputSubmitValue',
            ],
        ]);
    }
}
