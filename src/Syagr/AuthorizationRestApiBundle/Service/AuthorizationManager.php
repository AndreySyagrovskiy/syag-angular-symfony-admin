<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 06.01.16
 * Time: 21:31
 */

namespace Syagr\AuthorizationRestApiBundle\Service;

use Syagr\CMSBundle\Traits\SetEntityManagerTrait;
use Syagr\CMSBundle\Traits\SetTanslaitorTrait;
use Syagr\CMSBundle\Traits\SetSecurityEncoderFactoryTrait;
use Syagr\CMSBundle\Exception\AccessForbiddenManagerException;
use Syagr\CMSBundle\Service\ResponseAbleManager;
use FOS\UserBundle\Model\UserInterface;
use Syagr\AuthorizationRestApiBundle\Entity\UserToken;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class AuthorizationManager extends ResponseAbleManager
{
    use SetEntityManagerTrait;
    use SetTanslaitorTrait;
    use SetSecurityEncoderFactoryTrait;
    use ContainerAwareTrait;

    const APPLICATION_TOKEN_ENTITY = 'SyagrAuthorizationRestApiBundle:ApplicationToken';
    const USER_TOKEN_ENTITY        = 'SyagrAuthorizationRestApiBundle:UserToken';
    const USER_ENTITY              = 'AppBundle:User';

    /**
     * @var UserInterface
     */
    protected $user;

    protected $permissions;


    protected $timeLiveToken   = 21600;
    protected $timeUpdateToken = 3600;

    /**
     * @param string $login
     * @param string $password
     * @param string $appToken
     * @return string
     * @throws AccessForbiddenManagerException
     */
    public function logIn($login, $password, $appToken){
        $this->checkApplicationToken($appToken);

        $userR = $this->em->getRepository(self::USER_ENTITY);
        /**
         * @var UserInterface
         */
        $user = $userR->findOneByUsername($login);

        if($user){
            $encoder = $this->encoderFactory->getEncoder($user);

            if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {

                if(!$user->isEnabled())
                    throw new AccessForbiddenManagerException('User is disabled!');

                $token = bin2hex(random_bytes(78));
                $refreshToken = bin2hex(random_bytes(78));

                $userToken = new UserToken();
                $userToken->setToken($token);
                $userToken->setRefreshToken($refreshToken);
                $userToken->setExpiredDate((new \DateTime())->add(new \DateInterval('PT'.$this->timeLiveToken.'S')));
                $userToken->setUser($user);

                $this->em->persist($userToken);
                $this->em->flush();

                $this->user = $user;

            } else {
                throw new AccessForbiddenManagerException('Login or password is wrong!');
            }

        } else {
            throw new AccessForbiddenManagerException('Login or password is wrong!');
        }



        return [
                'token'         => $token,
                'refreshToken'  => $refreshToken,
                'user'          => $user,
                'permissions'   => $this->getUserPermissions()
            ];
    }

    /**
     * @param string $token
     * @throws AccessForbiddenManagerException
     */
    public function checkApplicationToken($token){
        $aTRepository =  $this->em->getRepository(self::APPLICATION_TOKEN_ENTITY);

        $atE = $aTRepository->findOneByToken($token);

        if(!$atE)
            throw new AccessForbiddenManagerException('Invalid application token');
    }

    /**
     * @return UserInterface
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * @return array
     */
    public function getUserPermissions(){

        if($this->permissions)
            return $this->permissions;

        $permissions = [];
        $apiAccesses = $this->container->getParameter('api_access');
        $userRoles = $this->user->getRoles();

        if(isset($userRoles[0])){
            foreach($userRoles as $userRole){
                $permissions = $this->permissionsExtend($permissions, $apiAccesses[$userRole]);
            }
        } else {
            $permissions = $apiAccesses['DEFAULT'];
        }

        $this->permissions = $permissions;

        return $permissions;
    }

    /**
     * @param string $entity
     * @param string $action
     * @return bool
     */
    public function checkUserPermissions($entity, $action){
        $permissions = $this->getUserPermissions();

        if(isset($permissions[$entity]) && in_array($action, $permissions[$entity])){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param array $permissions
     * @param array $additionPermissions
     * @return array mixed
     */
    protected function permissionsExtend($permissions, $additionPermissions){
        foreach($additionPermissions as $keyPerm => $permission){
            if(isset($permissions[$keyPerm])){
                foreach($permission as $item){
                    if(!in_array($item, $permissions[$keyPerm]))
                        $permissions[$keyPerm][] = $item;
                }
            } else {
                $permissions[$keyPerm] = $permission;
            }
        }

        return $permissions;
    }

    /**
     * @param string $token
     * @return null|UserToken
     */
    public function getUserToken($token){
        $userToken = $this->em->getRepository(self::USER_TOKEN_ENTITY)
            ->findOneBy(array('token' => $token));

        if($userToken)
            $this->user = $userToken->getUser();

        return $userToken;
    }

    /**
     * @param $token
     * @return array
     * @throws AccessForbiddenManagerException
     */
    public function getUserDataByToken($token){
        $userToken = $this->getUserToken($token);

        if(!$userToken) {
            throw new AccessForbiddenManagerException('Token is wrong!');
        } else {
            $dateTime = $userToken->getExpiredDate();
        }

        if($dateTime < new \DateTime())
            throw new AccessForbiddenManagerException('Token is expired!');


        if(!$this->getUser()->isEnabled())
            throw new AccessForbiddenManagerException('User is disabled!');

        return [
            'token'         => $token,
            'refreshToken'  => $userToken->getRefreshToken(),
            'user'          => $this->getUser(),
            'permissions'   => $this->getUserPermissions(),
        ];
    }
}