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

class CreateApplication extends BaseForm
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
                'label' => 'applicationFormName',
                'description' => 'applicationFormNameDesc',
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'description',
            'options' => [
                'label' => 'applicationFormDescription',
                'description' => 'applicationFormDescriptionDesc',
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'homepage',
            'options' => [
                'label' => 'applicationFormHomepage',
                'description' => 'applicationFormHomepageDesc',
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'redirectUri',
            'options' => [
                'label' => 'applicationFormRedirectUri',
                'description' => 'applicationFormRedirectUriDesc',
            ],
        ]);

        $this->add([
            'type' => 'Submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'applicationFormSubmit',
            ],
        ]);
    }
}
