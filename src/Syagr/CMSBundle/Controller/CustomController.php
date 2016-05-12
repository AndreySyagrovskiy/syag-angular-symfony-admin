<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 23.01.16
 * Time: 14:46
 */

namespace Syagr\CMSBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomController extends FOSRestController
{
    /**
     * @Get("/api/customs/customconfig.js",
     *     name="api_v1_customsjs",
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
    public function getConfigAction(){
        $data = $this->getParameter('customfields');
        $customfields = json_encode($this->getParameter('customfields'));
        
        $this->get('syagr_cms.custom_fields_service')->convertToArray($data);

        $customfields = json_encode($data);
        $response = new Response(
            $this->renderView("SyagrCMSBundle:Custom:customs.js.twig",
                [
                    'data' => $customfields,
                ])
        );
        $response->headers->set('Content-Type', 'text/javascript');
        return $response;
    }
}