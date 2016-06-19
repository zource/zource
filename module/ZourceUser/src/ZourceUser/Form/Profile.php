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

class Profile extends BaseForm
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
                'label' => 'profileFormName',
                'description' => 'profileFormNameDesc',
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'middle_name',
            'options' => [
                'label' => 'profileFormMiddleName',
                'description' => 'profileFormMiddleNameDesc',
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'last_name',
            'options' => [
                'label' => 'profileFormSurname',
                'description' => 'profileFormSurnameDesc',
            ],
        ]);

        $this->add([
            'type' => 'Submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'profileFormSubmit',
            ],
        ]);
    }
}
