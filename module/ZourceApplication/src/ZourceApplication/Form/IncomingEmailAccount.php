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
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class IncomingEmailAccount extends Form
{
    public function init()
    {
        $this->add([
            'name' => 'token',
            'type' => Csrf::class,
        ]);

        $this->add([
            'name' => 'type',
            'type' => Select::class,
            'options' => [
                'label' => 'Type',
                'description' => 'The connection type.',
                'empty_option' => '---',
                'value_options' => [
                    'imap' => 'IMAP',
                ],
            ],
        ]);

        $this->add([
            'name' => 'hostname',
            'type' => Text::class,
            'options' => [
                'label' => 'Hostname',
                'description' => 'The hostname of the incoming server.',
            ],
        ]);

        $this->add([
            'name' => 'port',
            'type' => Text::class,
            'options' => [
                'label' => 'Port',
                'description' => 'The port number of the incoming server.',
            ],
        ]);

        $this->add([
            'name' => 'username',
            'type' => Text::class,
            'options' => [
                'label' => 'Username',
                'description' => 'The username of the incoming server.',
            ],
            'attributes' => [
                'autocomplete' => 'off',
            ],
        ]);

        $this->add([
            'name' => 'password',
            'type' => Text::class,
            'options' => [
                'label' => 'Password',
                'description' => 'The password of the incoming server.',
            ],
            'attributes' => [
                'autocomplete' => 'off',
            ],
        ]);

        $this->add([
            'name' => 'ssl',
            'type' => Select::class,
            'options' => [
                'label' => 'SSL',
                'description' => 'Whether or not to connect over SSL.',
                'empty_option' => 'No',
                'value_options' => [
                    'ssl' => 'SSL',
                    'tls' => 'TLS',
                ],
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
