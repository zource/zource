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

class AdminAccount extends BaseForm
{
    public function init()
    {
        $this->add([
            'type' => 'Csrf',
            'name' => 'token',
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'first_name',
            'options' => [
                'label' => 'First name',
                'description' => 'The first name of the person to which the account belongs.',
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'middle_name',
            'options' => [
                'label' => 'Middle name',
                'description' => 'The middle name of the person to which the account belongs.',
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'last_name',
            'options' => [
                'label' => 'Last name',
                'description' => 'The last name of the person to which the account belongs.',
            ],
        ]);

        $this->add([
            'type' => 'Submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Save',
            ],
        ]);
    }
}
