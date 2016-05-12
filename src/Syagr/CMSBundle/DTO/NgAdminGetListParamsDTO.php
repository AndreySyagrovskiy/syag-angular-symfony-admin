<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 03.01.16
 * Time: 21:57
 */

namespace Syagr\CMSBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

class NgAdminGetListParamsDTO
{

    /**
     * @Assert\GreaterThan(
     *     value = 0
     * )
     */
    public $_page = 1;

    /**
     * @Assert\GreaterThan(
     *     value = 0
     * )
     */
    public $_perPage = 1;

    /**
     * @Assert\Choice(choices = {"ASC", "DESC"}, message = "Field is not valid")
     */
    public $_sortDir = 'ASC';

    public function bindRequest(Request $request){
        if($request->query->get('_page', false))
            $this->_page = $request->query->get('_page');

        if($request->query->get('_perPage', false))
            $this->_perPage = $request->query->get('_perPage');

        if($request->query->get('_sortDir', false))
            $this->_sortDir = $request->query->get('_sortDir');

        if($request->query->get('_sortField', false))
            $this->_sortField = $request->query->get('_sortField');


        return $this;
    }

}