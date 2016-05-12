<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 07.03.16
 * Time: 23:41
 */

namespace Syagr\MediaBundle\Traits;

use Syagr\MediaBundle\Service\ContextService;

trait SetContextServiceTrait
{
    /**
     * @var ContextService
     */
    protected $contextService;

    /**
     * @param ContextService $contextService
     * @return $this
     */
    public function setContextService($contextService)
    {
        $this->contextService = $contextService;

        return $this;
    }
}