<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class InstallPlugin extends Form
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
                'description' => 'The name of the plugin to install.',
            ],
        ]);

        $this->add([
            'type' => 'Submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Install',
            ],
        ]);
    }
}
