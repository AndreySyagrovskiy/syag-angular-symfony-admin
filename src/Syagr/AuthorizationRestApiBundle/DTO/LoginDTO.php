<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 09.01.16
 * Time: 13:29
 */

namespace Syagr\AuthorizationRestApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

class LoginDTO
{
    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3
     * )
     */
    public $login;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3
     * )
     */
    public $password;

    /**
     * @var string
     * @Assert\NotBlank
     */
    public $appToken;

    public function bindRequest(Request $request){
        $this->login    = $request->request->get('login');
        $this->password = $request->request->get('password');
        $this->appToken = $request->request->get('appToken');

        return $this;
    }
}