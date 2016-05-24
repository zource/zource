<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceContact\Form;

use Zend\Form\Form as BsaeForm;

class Person extends BsaeForm
{
    public function init()
    {
        $this->add([
            'type' => 'Csrf',
            'name' => 'token',
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'name',
            'options' => [
                'label' => 'Name',
                'description' => 'The first name of the person.',
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'middleName',
            'options' => [
                'label' => 'Middle name',
                'description' => 'The middle name of the person.',
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'familyName',
            'options' => [
                'label' => 'Family name',
                'description' => 'The family name of the person.',
            ],
        ]);

        $this->add([
            'type' => 'Submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Create',
            ],
        ]);
    }
}
