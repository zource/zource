<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Form;

use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class Cronjob extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'token',
            'type' => Csrf::class,
        ]);

        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label' => 'Name',
                'description' => 'The display name of the cronjob.',
            ],
        ]);

        $this->add([
            'name' => 'pattern',
            'type' => Text::class,
            'options' => [
                'label' => 'Pattern',
                'description' => 'The pattern of the cronjob.',
            ],
            'attributes' => [
                'value' => '* * * * *',
            ],
        ]);

        $this->add([
            'name' => 'command',
            'type' => Text::class,
            'options' => [
                'label' => 'Command',
                'description' => 'The command to execute.',
            ],
        ]);

        $this->add([
            'name' => 'active',
            'type' => Checkbox::class,
            'options' => [
                'label' => 'Active',
                'description' => 'Whether or not the cronjob is active.',
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
