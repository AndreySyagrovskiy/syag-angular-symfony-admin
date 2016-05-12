<?php

namespace Syagr\AuthorizationRestApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Syagr\AuthorizationRestApiBundle\DTO\LoginDTO;


class AuthorizationController extends FOSRestController
{
    /**
     * @Post("/api/authorization/login",
     *     name="api_v1_authorization_login",
     *     defaults={"_format":"json",
     *     "_locale":"en"},
     *     requirements={"_locale":"en|fr"},
     *     options={"expose":true}
     * )
     *
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $loginDTO = new LoginDTO();
        $validator = $this->get('validator');
        $errors = $validator->validate($loginDTO->bindRequest($request));

        if(count($errors)){
            return $this->handleView(
                $this->view(
                    $this
                        ->get('syagr_cms.error_process')
                        ->getResponseErrors($errors),
                    Response::HTTP_BAD_REQUEST
                )
            );
        }

        $response = $this
                            ->get('syagr.authorization_rest_api.athorization_manager')
                            ->getResponse('logIn', $loginDTO->login, $loginDTO->password, $loginDTO->appToken);

        $view = $this->view($response['response'], $response['code']);

        $context = new SerializationContext();
        $context->setGroups('default');
        $view->setSerializationContext($context);

        return $this->handleView($view);

    }

    /**
     * @Get("/api/authorization/userdata/{token}",
     *     name="api_v1_authorization_get_userdatan",
     *     defaults={"_format":"json",
     *     "_locale":"en"},
     *     requirements={
     *          "_locale":"en|fr",
     *          "token":"\w{30,200}"
     *     },
     *     options={"expose":true}
     * )
     *
     * @param string $token
     * @return Response
     */
    public function getUserDataByTokenAction($token)
    {
        $response = $this
            ->get('syagr.authorization_rest_api.athorization_manager')
            ->getResponse('getUserDataByToken', $token);

        $view = $this->view($response['response'], $response['code']);

        $context = new SerializationContext();
        $context->setGroups('default');
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * @Get("/api/authorization/userdata.js",
     *     name="api_v1_authorization_get_userdatajs",
     *     defaults={
     *      "_locale":"en"},
     *      requirements={
     *          "_locale":"en|fr",
     *     },
     *     options={"expose":true}
     * )
     *
     * @return Response
     */
    public function getUserDataAction(Request $request){
        $token = $request->cookies->get('token', 'notoken');

        $data = null;

        try{
            $data = json_encode(
                $this
                    ->get('syagr.authorization_rest_api.athorization_manager')
                    ->getUserDataByToken($token)
            );
        }catch(\Syagr\CMSBundle\Exception\AccessForbiddenManagerException $ex){

        }

        $response = new Response(
                $this->renderView("SyagrAuthorizationRestApiBundle:Default:userinfo.js.twig",
                    [
                        'data' => $data,
                    ])
            );
        $response->headers->set('Content-Type', 'text/javascript');
        return $response;
    }
}
