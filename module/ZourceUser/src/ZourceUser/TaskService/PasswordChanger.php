<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\TaskService;

use Doctrine\ORM\EntityManager;
use Zend\Crypt\Password\PasswordInterface;
use ZourceUser\V1\Rest\Account\AccountEntity;

class PasswordChanger
{
    private $entityManager;
    private $crypter;

    public function __construct(EntityManager $entityManager, PasswordInterface $crypter)
    {
        $this->entityManager = $entityManager;
        $this->crypter = $crypter;
    }

    public function changePassword(AccountEntity $account, $newPassword)
    {
        $credential = $this->crypter->create($newPassword);

        $account->setCredential($credential);

        $this->entityManager->persist($account);
        $this->entityManager->flush($account);
    }

    public function assignResetCredentialCode($emailAddress)
    {
        $emailAddressRepository = $this->entityManager->getRepository(EmailEntity::class);

        /** @var EmailEntity $emailAddress */
        $emailAddress = $emailAddressRepository->findOneBy([
            'address' => $emailAddress,
        ]);

        if (!$emailAddress || !$emailAddress->isVerified()) {
            return;
        }

        mail('walter.tamboer@live.com', 'Subject', 'data');
        exit('done');

        $validChars = implode('', array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9')));
        $emailAddress->getAccount()->setResetCredentialCode(Rand::getString(32, $validChars));

        $this->passwordChanger->flush($emailAddress->getAccount());

        $transport = \Swift_MailTransport::newInstance();

        $logger = new \Swift_Plugins_Loggers_EchoLogger();

        $mailer = new \Swift_Mailer($transport);
        $mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin($logger));

        /** @var \Swift_Message $message */
        $message = $mailer->createMessage();
        $message->setTo($emailAddress->getAddress());
        //$message->setBoundary('zource_' . md5(time()));
        $message->setSubject('Test');
        $message->setBody('This is a test.');
        $message->addPart('<q>Here is the message itself</q>', 'text/html');

        $failures = [];
        $result = $mailer->send($message, $failures);

        var_dump($data, $failures, $result, $logger->dump());
        exit;
    }

    public function resetAccountPassword($resetCode, $newPassword)
    {
        /** @var AccountEntity $account */
        $account = $this->entityManager->getRepository(AccountEntity::class)->findOneBy([
            'resetCredentialCode' => $resetCode,
        ]);

        if (!$account) {
            return null;
        }

        $account->setResetCredentialCode(null);

        $this->changePassword($account, $newPassword);

        return $account;
    }
}
