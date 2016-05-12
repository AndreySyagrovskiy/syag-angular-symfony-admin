<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 04.01.16
 * Time: 12:17
 */

namespace Syagr\CMSBundle\Traits;


trait RepositoryHelperTrait
{
    /**
     * @param array $criteria
     * @return string
     */
    protected function makeAndWhereString(array $criteria, $name = false){
        $tempArr = [];
        foreach($criteria as $key => $item){
            $tempArr[] = sprintf('%s = :%s', ($name ? '.'.$name : '').$key, str_replace('.', '_', $key));
        }

        return implode(' and ', $tempArr);
    }

    /**
     * @param array $criterias
     * @return array
     */
    protected function getParamsArray(array $criterias){
        $newArray = [];

        foreach($criterias as $k => $i){
            $newArray[str_replace('.', '_', $k)] = $i;
        }

        return $newArray;
    }
}