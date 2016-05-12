<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 03.01.16
 * Time: 18:44
 */

namespace Syagr\CMSBundle\Traits;

use Doctrine\ORM\EntityManager;


trait SetEntityManagerTrait
{
    /** @var EntityManager $em */
    protected $em;


    /**
     * @param EntityManager $em
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

}