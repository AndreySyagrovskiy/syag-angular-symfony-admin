<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 03.01.16
 * Time: 18:42
 */

namespace Syagr\PageBundle\Service;


use Syagr\CMSBundle\Traits\SetEntityManagerTrait;
use Syagr\CMSBundle\Traits\SetTanslaitorTrait;
use Syagr\CMSBundle\Service\ResponseAbleManager;
use Syagr\CMSBundle\Exception\ManagerException;
use Syagr\CMSBundle\Exception\NotFoundManagerException;
use Syagr\CMSBundle\Exception\AccessForbiddenManagerException;
use Symfony\Component\HttpFoundation\Request;
use Syagr\PageBundle\Entity\Page;

class PageManager extends ResponseAbleManager
{
    use SetEntityManagerTrait;
    use SetTanslaitorTrait;

    const PAGE_ENTITY = 'SyagrPageBundle:Page';

    /**
     * @param array $params
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getPages(array $params){
        $em = $this->em;
        $pR = $em->getRepository(PageManager::PAGE_ENTITY);

        return $pR->getPages($params['filterParams'], $params['orderParams'], $params['limit'], $params['first']);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deletePage($id){
        $em = $this->em;
        $pR = $em->getRepository(PageManager::PAGE_ENTITY);
        $entity = $pR->findOneById($id);

        if($entity){
            $em->remove($entity);
            $em->flush();
        }

        return true;
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundManagerException
     */
    public function showPage($id){
        $em = $this->em;
        $pR = $em->getRepository(PageManager::PAGE_ENTITY);
        $entity = $pR->findOneById($id);

        if(!$entity)
            throw new NotFoundManagerException(sprintf("Page with id '%d' not found", $id));

        return $entity;
    }

    /**
     * @param Page $page
     * @return Page
     */
    public function updatePage(Page $page){
        $this->em->flush();

        return $page;
    }

    /**
     * @param Page $page
     * @return Page
     */
    public function createPage(Page $page){
        $this->em->persist($page);
        $this->em->flush();

        return $page;
    }

    /**
     * @return Page
     */
    public function getNewPageObject(){
        return new Page();
    }

}