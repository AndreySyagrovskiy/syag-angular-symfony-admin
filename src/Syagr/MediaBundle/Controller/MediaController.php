<?php

namespace Syagr\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Request;
use Syagr\CMSBundle\Traits\MakeListParametersTrait;
use Symfony\Component\HttpFoundation\Response;
use Syagr\PageBundle\DTO\NgAdminGetPageListParamsDTO;
use Syagr\PageBundle\DTO\NgAdminPageEditDTO;

class MediaController extends FOSRestController
{
    /**
     * @Post("/upload",
     *     name="api_v1_upload",
     *     defaults={"_format":"json",
     *     "_locale":"en"},
     *     requirements={"_locale":"en|fr"},
     *     options={"expose":true}
     * )
     *
     * @return Response
     */
    public function uploadAction(Request $request)
    {
        $file = $request->files->get('file');
        $context  = $request->query->get('context', 'default');
        $provider = $request->query->get('provider', 'file');
        $response = $this->get('syagr_media.media_manager')->getResponse('addToMedia', $file, $context, $provider);
        $view = $this->view($response['response'], $response['code']);
        return $this->handleView($view);
    }
}
