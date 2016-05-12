<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 04.01.16
 * Time: 12:08
 */

namespace Syagr\PageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Syagr\CMSBundle\Traits\RepositoryHelperTrait;

class PageRepository extends EntityRepository
{
    use RepositoryHelperTrait;

    /**
     * @param array $filters
     * @param array $orders
     * @param int $limit
     * @param int $first
     * @return Paginator
     */
    public function getPages(array $filters, array $orders, $limit, $first){
        $pQB = $this->createQueryBuilder('p');
        $this->makeAndWhereString($filters);
        if(count($filters)) {
            $pQB->where($this->makeAndWhereString($filters));
            $pQB->setParameters($this->getParamsArray($filters));
        }

        foreach($orders as $key => $item){
            $pQB->addOrderBy('p.'.$key, $item);
        }

        $pQB->setMaxResults($limit);
        $pQB->setFirstResult($first);

        $paginator = new Paginator($pQB->getQuery());

        return $paginator;
    }
}