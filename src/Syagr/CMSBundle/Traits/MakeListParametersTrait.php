<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 04.01.16
 * Time: 0:48
 */

namespace Syagr\CMSBundle\Traits;


trait MakeListParametersTrait
{
    public function makeListParameters($listParamsDTO){
        $params = [];
        $params['filterParams'] = [];

        $params['orderParams'] = [$listParamsDTO->_sortField => $listParamsDTO->_sortDir];

        $params['limit'] = $listParamsDTO->_perPage;
        $params['first'] = ($listParamsDTO->_page - 1) * $params['limit'];

        return $params;
    }
}