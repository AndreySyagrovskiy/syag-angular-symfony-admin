<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 07.03.16
 * Time: 21:25
 */

namespace Syagr\MediaBundle\Service;

use Syagr\MediaBundle\Model\Context;
use Syagr\MediaBundle\Traits\SetProviderServiceTrait;

class ContextService
{
    use SetProviderServiceTrait;

    protected $configProviderPrefix = 'syagr_media.providers.';
    protected $contexts = [];
    protected $readyContexts = [];

    function __construct($contexts){
        $this->contexts = $contexts;
    }

    /**
     * @param string $nameContext
     * @return null|Context
     */
    function getContext($nameContext="default"){
        if(isset($this->contexts[$nameContext])){
            if(isset($this->readyContexts[$nameContext])) {
                return $this->readyContexts[$nameContext];
            } else {
                $context = new Context($nameContext);

                foreach($this->contexts[$nameContext]['providers'] as $item){
                    $provider = $this->providerService->getProvider(str_replace('syagr_media.providers.', '', $item));
                    if($provider)
                        $context->addProvider($provider);
                }

                $this->readyContexts[$nameContext] = $context;

                return $context;
            }
        } else {
            return null;
        }
    }
}