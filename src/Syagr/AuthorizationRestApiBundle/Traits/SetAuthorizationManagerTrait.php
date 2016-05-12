<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 11.01.16
 * Time: 14:27
 */

namespace Syagr\AuthorizationRestApiBundle\Traits;

use Syagr\AuthorizationRestApiBundle\Service\AuthorizationManager;


trait SetAuthorizationManagerTrait
{
    /**
     * @var AuthorizationManager
     */
    protected $authorizationManager;

    /**
     * @param AuthorizationManager $authorizationManager
     */
    function setAuthorizationManager($authorizationManager){
        $this->authorizationManager = $authorizationManager;
    }
}