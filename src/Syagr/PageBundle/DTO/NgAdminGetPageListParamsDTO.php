<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 03.01.16
 * Time: 23:52
 */

namespace Syagr\PageBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Syagr\CMSBundle\DTO\NgAdminGetListParamsDTO;

class NgAdminGetPageListParamsDTO extends NgAdminGetListParamsDTO
{
    /**
     * @Assert\Choice(choices = {"id", "title", "text", "slug"}, message = "Field is not valid")
     */
    public $_sortField = 'id';
}