<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 07.03.16
 * Time: 23:21
 */

namespace Syagr\MediaBundle\Traits;

use Syagr\MediaBundle\Service\ProviderService;


trait SetProviderServiceTrait
{
    /**
     * @var ProviderService
     */
    protected $providerService;

    /**
     * @param ProviderService $providerService
     * @return $this
     */
    public function setProviderService($providerService){
        $this->providerService = $providerService;

        return $this;
    }
}