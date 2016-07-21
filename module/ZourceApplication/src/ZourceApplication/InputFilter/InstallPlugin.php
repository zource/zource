<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\InputFilter;

use Zend\Filter\File\RenameUpload;
use Zend\Filter\StringTrim;
use Zend\InputFilter\InputFilter;
use Zend\Validator\File\IsCompressed;

class InstallPlugin extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'location',
            'required' => false,
            'filters' => [
                [
                    'name' => StringTrim::class,
                ],
            ],
        ]);

        $this->add([
            'name' => 'plugin',
            'required' => false,
            'filters' => [
                [
                    'name' => RenameUpload::class,
                    'options' => [
                        'target' => 'data/tmp/',
                        'use_upload_name' => true,
                        'use_upload_extension' => true,
                        'randomize' => true,
                    ],
                ],
            ],
            'validators' => [
                [
                    'name' => IsCompressed::class,
                    'options' => [
                        'magicFile' => false,
                    ],
                ],
            ],
        ]);
    }
}
