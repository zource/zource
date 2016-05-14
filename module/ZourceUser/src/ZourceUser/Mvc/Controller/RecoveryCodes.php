<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Mvc\Controller;

use Base32\Base32;
use Zend\Http\Response\Stream;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use ZourceApplication\TaskService\RemoteAddressLookup;
use ZourceApplication\TaskService\Session;
use ZourceUser\Authentication\AuthenticationService;

class RecoveryCodes extends AbstractActionController
{
    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @var Session
     */
    private $sessionService;

    /**
     * @var Container
     */
    private $session2FA;

    public function __construct(
        AuthenticationService $authenticationService,
        Session $sessionService,
        Container $session2FA
    ) {
        $this->authenticationService = $authenticationService;
        $this->sessionService = $sessionService;
        $this->session2FA = $session2FA;
    }

    public function indexAction()
    {
        $account = $this->authenticationService->getAccountEntity();
        
        return new ViewModel([
            'account' => $account,
            'remoteAddressLookup' => $this->sessionService->getRemoteAddressLookup(),
            'sessions' => $this->sessionService->getForAccount($account),
            'userAgentParser' => $this->sessionService->getUserAgentParser(),
        ]);
    }

    public function revokeSessionAction()
    {
        $session = $this->sessionService->getSession($this->params('id'));

        if (!$session) {
            return $this->notFoundAction();
        }

        if ($this->zourceAccount() !== $session->getAccount()) {
            return $this->notFoundAction();
        }

        $this->sessionService->deleteSession($session);

        return $this->redirect()->toRoute('settings/security');
    }

    public function tfaEnableAction()
    {
        if (!$this->session2FA->secretCode) {
            $this->session2FA->secretCode = Base32::encode(random_bytes(256));
        }

        $totp = new \OTPHP\TOTP('Zource', $this->session2FA->secretCode);

        if ($this->getRequest()->isPost()) {
            $code = $this->getRequest()->getPost('code');

            var_dump($totp->verify($code));
        }

        return new ViewModel([
            'secretCode' => $this->session2FA->secretCode,
        ]);
    }

    public function tfaDisableAction()
    {
        return $this->redirect()->toRoute('settings/security');
    }

    public function tfaRenderQrCodeAction()
    {
        $filePath = tempnam('data/tmp/', '2fa-qr-');

        $renderer = new \BaconQrCode\Renderer\Image\Png();
        $renderer->setForegroundColor(new \BaconQrCode\Renderer\Color\Rgb(170, 45, 76));
        $renderer->setHeight(256);
        $renderer->setWidth(256);

        $writer = new \BaconQrCode\Writer($renderer);
        $writer->writeFile('123456', $filePath);

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
