<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 07.03.16
 * Time: 22:10
 */

namespace Syagr\MediaBundle\Service;
use Syagr\MediaBundle\Traits\SetFilesystemMap;
use Syagr\MediaBundle\Model\Provider;

class ProviderService
{
    use SetFilesystemMap;

    /**
     * @var array
     */
    protected $providers = [];
    /**
     * @var array
     */
    protected $providersReady = [];

    /**
     * @param Provider $providers
     */
    function __construct($providers){
        $this->providers = $providers;
    }

    /**
     * @param string $name
     * @return null|Provider
     */
    function getProvider($name){
        $providers = $this->providers;
        if(isset($providers[$name])){
            if(isset($this->providersReady[$name])) {
                return $this->providersReady[$name];
            } else {
                $this->providersReady[$name] = new Provider(
                        $name,
                        $this->filesystemMap->get($providers[$name]['filesystem']),
                        $providers[$name]['allowed_mime_types'],
                        $providers[$name]['allowed_files_extensions']
                    );

                return $this->providersReady[$name];
            }
        } else {
            return null;
        }
    }

    /**
     * @param string $name
     * @return null|Provider
     */
    function getProviderFilesystemName($name){
        $providers = $this->providers;
        
        return $providers[$name]? $providers[$name]['filesystem'] : null;
    }
}