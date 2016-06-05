<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;
use OTPHP\TOTP;
use Zend\Http\Response\Stream;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZourceUser\Form\VerifyCode;
use ZourceUser\TaskService\TwoFactorAuthentication as TwoFactorAuthenticationService;
use ZourceUser\Entity\AccountInterface;

class TwoFactorAuthentication extends AbstractActionController
{
    /**
     * @var TwoFactorAuthenticationService
     */
    private $tfaService;

    /**
     * @var VerifyCode
     */
    private $verifyCodeForm;

    public function __construct(TwoFactorAuthenticationService $tfaService, VerifyCode $verifyCodeForm)
    {
        $this->tfaService = $tfaService;
        $this->verifyCodeForm = $verifyCodeForm;
    }

    public function enableAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->verifyCodeForm->setData($this->getRequest()->getPost());

            /** @var \ZourceUser\InputFilter\VerifyCode $inputFilter */
            $inputFilter = $this->verifyCodeForm->getInputFilter();
            $inputFilter->setOneTimePasswordType(\ZourceUser\TaskService\TwoFactorAuthentication::OTP_TOTP);
            $inputFilter->setOneTimePasswordCode($this->tfaService->getSecret());

            if ($this->verifyCodeForm->isValid()) {
                $secret = $this->tfaService->getSecret();

                $this->tfaService->persistTwoFactorAuthentication($this->zourceAccount(), $secret);
                $this->tfaService->clearSecret();

                return $this->redirect()->toRoute('settings/security');
            }
        }

        return new ViewModel([
            'secretCode' => $this->tfaService->getSecret(),
            'verifyCodeForm' => $this->verifyCodeForm,
        ]);
    }

    public function disableAction()
    {
        $this->tfaService->clearSecret();
        $this->tfaService->clearTwoFactorAuthentication($this->zourceAccount());

        return $this->redirect()->toRoute('settings/security');
    }

    public function renderQrCodeAction()
    {
        /** @var AccountInterface $account */
        $account = $this->zourceAccount();

        $oneTimePassword = new TOTP($account->getContact()->getFullName(), $this->tfaService->getSecret());
        $oneTimePassword->setIssuer('Zource');
        $oneTimePassword->setIssuerIncludedAsParameter(true);
        $oneTimePassword->setParameter('image', $this->url()->fromRoute('settings/security/tfa-image', [], [
            'force_canonical' => true,
        ]));

        $filePath = tempnam('data/tmp/', '2fa-qr-');

        $renderer = new Png();
        $renderer->setHeight(256);
        $renderer->setWidth(256);

        $writer = new Writer($renderer);
        $writer->writeFile($oneTimePassword->getProvisioningUri(true), $filePath);

        $response = new Stream();
        $response->setCleanup(true);
        $response->setStream(fopen($filePath, 'rb'));
        $response->setStreamName($filePath);

        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Length', filesize($filePath));
        $headers->addHeaderLine('Content-Type', 'image/png');

        return $response;
    }
}
