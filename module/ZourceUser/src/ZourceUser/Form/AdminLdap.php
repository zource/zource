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
use ZourceUser\Entity\Account;
use ZourceUser\Form\Element\LdapServer;

class AdminLdap extends BaseForm
{
    public function init()
    {
        $this->add([
            'type' => 'Csrf',
            'name' => 'token',
        ]);

        $this->add([
            'type' => 'Collection',
            'name' => 'servers',
            'options' => [
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => [
                    'type' => LdapServer::class,
                ],
            ],
        ]);

        $this->add([
            'type' => 'Checkbox',
            'name' => 'autoCreateAccount',
            'options' => [
                'label' => 'ldapDirectoryAutoCreateAccount',
                'description' => 'ldapDirectoryAutoCreateAccountDesc',
            ],
        ]);

        $this->add([
            'type' => 'Submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'ldapDirectorySubmit',
            ],
        ]);
    }
}
