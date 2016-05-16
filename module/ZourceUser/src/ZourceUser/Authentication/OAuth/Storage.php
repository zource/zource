<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceUser\Authentication\OAuth;

use DateTime;
use Doctrine\ORM\EntityManager;
use OAuth2\Storage\AccessTokenInterface;
use OAuth2\Storage\AuthorizationCodeInterface;
use OAuth2\Storage\ClientCredentialsInterface;
use OAuth2\Storage\RefreshTokenInterface;
use OAuth2\Storage\UserCredentialsInterface;
use Zend\Crypt\Password\PasswordInterface;
use ZourceUser\Entity\OAuthAccessToken;
use ZourceUser\Entity\OAuthApplication;
use ZourceUser\Entity\OAuthAuthorizationCode;
use ZourceUser\Entity\OAuthRefreshToken;
use ZourceUser\V1\Rest\Account\AccountEntity;
use ZourceUser\V1\Rest\Identity\IdentityEntity;

class Storage implements
    AccessTokenInterface,
    AuthorizationCodeInterface,
    ClientCredentialsInterface,
    RefreshTokenInterface,
    UserCredentialsInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var PasswordInterface
     */
    private $crypter;

    public function __construct(EntityManager $entityManager, PasswordInterface $crypter)
    {
        $this->entityManager = $entityManager;
        $this->crypter = $crypter;
    }

    /**
     * @param string $id
     * @return OAuthApplication
     */
    public function getApplication($id)
    {
        return $this->entityManager->getRepository(OAuthApplication::class)->find($id);
    }

    /**
     * @param string $id
     * @return AccountEntity
     */
    public function getAccount($id)
    {
        return $this->entityManager->getRepository(AccountEntity::class)->find($id);
    }

    /**
     * @param string $id
     * @return IdentityEntity
     */
    public function getIdentity($id)
    {
        return $this->entityManager->getRepository(IdentityEntity::class)->find($id);
    }

    public function getAccessToken($oauthToken)
    {
        /** @var OAuthAccessToken $accessToken */
        $accessToken = $this->entityManager->getRepository(OAuthAccessToken::class)->find($oauthToken);

        if (!$accessToken) {
            return null;
        }

        return [
            'client_id' => $accessToken->getApplication()->getClientId()->toString(),
            'user_id' => $accessToken->getAccount()->getId()->toString(),
            'expires' => $accessToken->getExpires()->format('U'),
            'scope' => $accessToken->getScope(),
            'id_token' => null,
        ];
    }

    public function setAccessToken($oauthToken, $clientId, $userId, $expires, $scope = null)
    {
        $application = $this->getApplication($clientId);
        if (!$application) {
            return;
        }

        /** @var AccountEntity $account */
        $account = $this->getAccount($userId);
        if (!$account) {
            return;
        }

        $expireDate = new DateTime();
        $expireDate->setTimestamp($expires);

        $accessToken = new OAuthAccessToken($oauthToken, $application, $account, $expireDate);
        $accessToken->setScope($scope);

        $this->entityManager->persist($accessToken);
        $this->entityManager->flush($accessToken);
    }

    public function getAuthorizationCode($code)
    {
        /** @var OAuthAuthorizationCode $authorizationCode */
        $authorizationCode = $this->entityManager->getRepository(OAuthAuthorizationCode::class)->find($code);

        if (!$authorizationCode) {
            return null;
        }

        return [
            'client_id' => $authorizationCode->getApplication()->getClientId()->toString(),
            'user_id' => $authorizationCode->getAccount()->getId()->toString(),
            'expires' => (int)$authorizationCode->getExpires()->format('U'),
            'redirect_uri' => $authorizationCode->getRedirectUri(),
            'scope' => $authorizationCode->getScope(),
        ];
    }

    public function setAuthorizationCode($code, $client_id, $user_id, $redirect_uri, $expires, $scope = null)
    {
        $authorizationCode = $this->getAuthorizationCode($code);

        if ($authorizationCode) {
            return false;
        }

        $application = $this->getApplication($client_id);
        $account = $this->getIdentity($user_id)->getAccount();

        $expireDate = new DateTime();
        $expireDate->setTimestamp($expires);

        $authorizationCode = new OAuthAuthorizationCode($code, $application, $account, $redirect_uri, $expireDate);
        $authorizationCode->setScope($scope);

        $this->entityManager->persist($authorizationCode);
        $this->entityManager->flush($authorizationCode);

        return true;
    }

    public function expireAuthorizationCode($code)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->delete();
        $qb->from(OAuthAuthorizationCode::class, 'a');
        $qb->where($qb->expr()->eq('a.authorizationCode', ':code'));
        $qb->setParameter(':code', $code);
        $qb->getQuery()->execute();
    }

    public function checkClientCredentials($clientId, $clientSecret = null)
    {
        $application = $this->getApplication($clientId);

        return $this->crypter->verify($clientSecret, $application->getClientSecret());
    }

    public function isPublicClient($clientId)
    {
        /** @var OAuthApplication $application */
        $application = $this->getApplication($clientId);

        if (!$application) {
            return false;
        }

        return empty($application->getClientSecret());
    }

    public function getClientDetails($clientId)
    {
        $application = $this->getApplication($clientId);

        if (!$application) {
            return false;
        }

        return [
            'client_id' => $application->getClientId()->toString(),
            'redirect_uri' => $application->getRedirectUri(),
            'grant_types' => null,
            'user_id' => null,
            'scope' => null,
        ];
    }

    public function getClientScope($client_id)
    {
        return '';
    }

    public function checkRestrictedGrantType($clientId, $grantType)
    {
        /** @var array $details */
        $details = $this->getClientDetails($clientId);

        if (isset($details['grant_types'])) {
            $grantTypes = explode(' ', $details['grant_types']);

            return in_array($grantType, (array)$grantTypes);
        }

        return true;
    }

    public function getRefreshToken($oauthToken)
    {
        /** @var OAuthRefreshToken $refreshToken */
        $refreshToken = $this->entityManager->getRepository(OAuthRefreshToken::class)->find($oauthToken);

        if (!$refreshToken) {
            return null;
        }

        return [
            'refresh_token' => null,
            'client_id' => $refreshToken->getApplication()->getClientId()->toString(),
            'user_id' => $refreshToken->getAccount()->getId()->toString(),
            'expires' => $refreshToken->getExpires()->format('U'),
            'scope' => $refreshToken->getScope(),
        ];
    }

    public function setRefreshToken($refreshToken, $clientId, $userId, $expires, $scope = null)
    {
        $application = $this->getApplication($clientId);
        if (!$application) {
            return;
        }

        /** @var AccountEntity $account */
        $account = $this->getAccount($userId);
        if (!$account) {
            return;
        }

        $expireDate = new DateTime();
        $expireDate->setTimestamp($expires);

        $refreshToken = new OAuthRefreshToken($refreshToken, $application, $account, $expireDate);
        $refreshToken->setScope($scope);

        $this->entityManager->persist($refreshToken);
        $this->entityManager->flush($refreshToken);
    }

    public function unsetRefreshToken($refreshToken)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->delete();
        $qb->from(OAuthRefreshToken::class, 't');
        $qb->where($qb->expr()->eq('t.refreshToken', ':token'));
        $qb->setParameter(':token', $refreshToken);
        $qb->getQuery()->execute();
    }

    public function checkUserCredentials($username, $password)
    {
        $identityRepository = $this->entityManager->getRepository(IdentityEntity::class);

        /** @var IdentityEntity $identity */
        $identity = $identityRepository->findOneBy([
            'directory' => 'username',
            'identity' => $username,
        ]);

        if (!$identity) {
            return false;
        }

        /** @var string $credential */
        $credential = $identity->getAccount()->getCredential();

        return $this->crypter->verify($password, $credential);
    }

    public function getUserDetails($username)
    {
        $identityRepository = $this->entityManager->getRepository(IdentityEntity::class);

        /** @var IdentityEntity $identity */
        $identity = $identityRepository->findOneBy([
            'directory' => 'username',
            'identity' => $username,
        ]);

        if (!$identity) {
            return false;
        }

        return [
            'user_id' => $identity->getAccount()->getId()->toString(),
            'scope' => '',
        ];
    }
}
