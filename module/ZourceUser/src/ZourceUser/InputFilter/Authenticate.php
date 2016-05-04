<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\InputFilter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationService;
use Zend\InputFilter\InputFilter;

class Authenticate extends InputFilter
{
    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function init()
    {
        $this->add([
            'name' => 'token',
            'required' => true,
        ]);

        $this->add([
            'name' => 'identity',
            'required' => true,
        ]);

        $this->add([
            'name' => 'credential',
            'required' => true,
            'validators' => [
                [
                    'name' => 'Zend\\Authentication\\Validator\\Authentication',
                    'options' => [
                        'adapter' => $this->authenticationService->getAdapter(),
                        'service' => $this->authenticationService,
                        'identity' => 'identity',
                        'credential' => 'credential',
                    ],
                ],
            ],
        ]);
    }
}
