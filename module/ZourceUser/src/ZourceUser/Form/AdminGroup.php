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
use ZourceUser\TaskService\Permissions;

class AdminGroup extends BaseForm
{
    private $permissionsTaskService;

    public function __construct(Permissions $permissionsTaskService)
    {
        parent::__construct();

        $this->permissionsTaskService = $permissionsTaskService;
    }

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
                'description' => 'The name of the group.',
            ],
        ]);

        $this->add([
            'type' => 'Textarea',
            'name' => 'description',
            'options' => [
                'label' => 'Description',
                'description' => 'The description of the group.',
            ],
        ]);

        $this->add([
            'type' => Select2::class,
            'name' => 'accounts',
            'options' => [
                'label' => 'Accounts',
                'description' => 'The accounts that are part of this group.',
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
            'type' => 'MultiCheckbox',
            'name' => 'permissions',
            'options' => [
                'label' => 'Permissions',
                'description' => 'The permissions the group has.',
                'value_options' => $this->permissionsTaskService->getPermissions(),
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
