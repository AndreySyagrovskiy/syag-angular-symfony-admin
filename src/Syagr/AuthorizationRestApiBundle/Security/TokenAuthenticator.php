<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 06.01.16
 * Time: 15:42
 */

namespace Syagr\AuthorizationRestApiBundle\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use Syagr\AuthorizationRestApiBundle\Traits\SetAuthorizationManagerTrait;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    use SetAuthorizationManagerTrait;

    const USER_ENTITY        = "AppBundle:User";
    const USER_TOKEN_ENTITY  = "SyagrAuthorizationRestApiBundle:UserToken";
    const APP_TOKEN_ENTITY   = "SyagrAuthorizationRestApiBundle:ApplicationToken";

    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';


    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Called on every request. Return whatever credentials you want,
     * or null to stop authentication.
     */
    public function getCredentials(Request $request)
    {
        if (!$token = $request->headers->get('X-AUTH-TOKEN')) {
            // no token? Return null and no other methods will be called
            return;
        }

        // What you return here will be passed to getUser() as $credentials
        return array(
            'token' => $token,
        );
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return null|User
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $credentials['token'];

        /**
         * @var \Syagr\AuthorizationRestApiBundle\Entity\UserToken
         */
        $userToken = $this->authorizationManager->getUserToken($token);

        if($userToken)
            $dateTime = $userToken->getExpiredDate();
        else
            return null;

        if($dateTime > new \DateTime())
            return $userToken->getUser();


        return null;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // check credentials - e.g. make sure the password is valid
        // no credential check is needed in this case

        // return true to cause authentication success
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = array(
            'error' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        );

        return new JsonResponse($data, 403);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            // you might translate this message
            'error' => 'Authentication Required'
        );

        return new JsonResponse($data, 401);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}