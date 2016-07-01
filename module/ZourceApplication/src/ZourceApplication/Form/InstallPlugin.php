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
use Zend\Form\Element\File;
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
            'name' => 'location',
            'type' => Text::class,
            'options' => [
                'label' => 'Location',
                'description' => 'The location to download the plugin from.',
            ],
        ]);

        $this->add([
            'name' => 'plugin',
            'type' => File::class,
            'options' => [
                'label' => 'Plugin',
                'description' => 'The plugin file to install.',
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
