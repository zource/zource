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
use ZourceApplication\Form\Element\Select2;
use ZourceUser\Entity\Account;

class AdminAccountCreation extends BaseForm
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
                'description' => 'The first name of the person to create the account for.',
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'middle_name',
            'options' => [
                'label' => 'Middle name',
                'description' => 'The middle name of the person to create the account for.',
            ],
        ]);

        $this->add([
            'type' => 'Text',
            'name' => 'last_name',
            'options' => [
                'label' => 'Last name',
                'description' => 'The last name of the person to create the account for.',
            ],
        ]);

        $this->add([
            'type' => 'Email',
            'name' => 'email',
            'options' => [
                'label' => 'E-mail address',
                'description' => 'The e-mail address of the person to create the account for.',
            ],
        ]);

        $this->add([
            'type' => 'Radio',
            'name' => 'status',
            'options' => [
                'label' => 'Status',
                'description' => 'The status of the account.',
                'value_options' => [
                    Account::STATUS_ACTIVE => 'Active',
                    Account::STATUS_INACTIVE => 'Inactive',
                ],
            ],
            'attributes' => [
                'value' => Account::STATUS_ACTIVE,
            ],
        ]);

        $this->add([
            'type' => Select2::class,
            'name' => 'groups',
            'options' => [
                'label' => 'Groups',
                'description' => 'The groups that this account is a member of.',
                'disable_inarray_validator' => true,
                'use_hidden_element' => true,
            ],
            'attributes' => [
                'multiple' => 'multiple',
                'class' => 'zui-select2',
                'data-zui-select2-url' => '', // Will be set in the view
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
