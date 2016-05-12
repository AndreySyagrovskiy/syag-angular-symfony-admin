<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 03.01.16
 * Time: 14:54
 */

namespace Syagr\PageBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use Syagr\CMSBundle\Traits\MakeListParametersTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Syagr\PageBundle\DTO\NgAdminGetPageListParamsDTO;
use Syagr\PageBundle\DTO\NgAdminPageEditDTO;



class PageController extends FOSRestController
{
    use MakeListParametersTrait;

    /**
     * @Get("/pages",
     *     name="api_v1_pages",
     *     defaults={"_format":"json",
     *     "_locale":"en"},
     *     requirements={"_locale":"en|fr"},
     *     options={"expose":true}
     * )
     *
     * @return Response
     */
    public function getPagesAction(Request $request)
    {
        $listParamsDTO = new NgAdminGetPageListParamsDTO();
        $validator = $this->get('validator');
        $errors = $validator->validate($listParamsDTO->bindRequest($request));

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

        $response = $this->get('syagr_page.page_manager')->getResponse('getPages', $this->makeListParameters($listParamsDTO));

        /*
        $context = new SerializationContext();
        $context->setAttribute('image_formats', array('reference'));
        $context->setGroups('default');
        $view->setSerializationContext($context);
        */

        $view = $this->view((array)$response['response']->getIterator(), $response['code']);
        $view->setHeader('X-Total-Count', $response['response']->count());


        return $this->handleView($view);
    }

    /**
     * @Delete("/pages/{id}",
     *     name="api_v1_page_delete",
     *     defaults={"_format":"json",
     *     "_locale":"en"},
     *     requirements={
     *          "_locale":"en|fr",
     *          "id":"\d+"
     *     },
     *     options={"expose":true}
     * )
     *
     * @return Response
     */
    public function deletePageAction($id)
    {
        $response = $this->get('syagr_page.page_manager')->getResponse('deletePage', $id);

        $view = $this->view($response['response'], $response['code']);

        return $this->handleView($view);
    }

    /**
     * @Get("/pages/{id}",
     *     name="api_v1_page_show",
     *     defaults={"_format":"json",
     *     "_locale":"en"},
     *     requirements={
     *          "_locale":"en|fr",
     *          "id":"\d+"
     *     },
     *     options={"expose":true}
     * )
     *
     * @return Response
     */
    public function showPageAction($id)
    {
        $response = $this->get('syagr_page.page_manager')->getResponse('showPage', $id);

        $view = $this->view($response['response'], $response['code']);

        return $this->handleView($view);
    }


    /**
     * @Put("/pages/{id}",
     *     name="api_v1_page_update",
     *     defaults={"_format":"json",
     *     "_locale":"en"},
     *     requirements={
     *          "_locale":"en|fr",
     *          "id":"\d+"
     *     },
     *     options={"expose":true}
     * )
     *
     * @return Response
     */
    public function updatePageAction(Request $request, $id)
    {
        $page = $this->get('syagr_page.page_manager')->showPage($id);
        $pageDTO = new NgAdminPageEditDTO();

        $pageDTO->bindPage($page);
        $pageDTO->bindRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($pageDTO);

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

        $pageDTO->loadDataToPage($page);

        $response = $this->get('syagr_page.page_manager')->getResponse('updatePage', $page);

        $view = $this->view($response['response'], $response['code']);

        return $this->handleView($view);
    }

    /**
     * @Post("/pages",
     *     name="api_v1_page_create",
     *     defaults={"_format":"json",
     *     "_locale":"en"},
     *     requirements={
     *          "_locale":"en|fr"
     *     },
     *     options={"expose":true}
     * )
     *
     * @return Response
     */
    public function createPageAction(Request $request)
    {
        $pageDTO = new NgAdminPageEditDTO();

        $pageDTO->bindRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($pageDTO);

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

        $page = $pageDTO->loadDataToPage($this->get('syagr_page.page_manager')->getNewPageObject());

        $response = $this->get('syagr_page.page_manager')->getResponse('createPage', $page);

        $view = $this->view($response['response'], $response['code']);

        return $this->handleView($view);
    }
}