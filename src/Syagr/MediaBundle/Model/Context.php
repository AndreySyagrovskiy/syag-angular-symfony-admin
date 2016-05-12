<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 07.03.16
 * Time: 21:45
 */

namespace Syagr\MediaBundle\Model;


class Context
{
    /**
     * @var array
     */
    protected $providers = [];
    /**
     * @var string
     */
    protected $name;

    /**
     * Context constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    public function addProvider($provider){
        $this->providers[$provider->getName()] = $provider;
    }

    /**
     * @param string $providerName
     * @return $this
     */
    public function removeProvider($providerName){
        if($providerName)
            unset($this->providers[$providerName]);

        return $this;
    }

    /**
     * @param string $providerName
     * @return null
     */
    public function getProvider($providerName){
        if(isset($this->providers[$providerName]))
            return $this->providers[$providerName];
        else
            return null;
    }

    /**
     * @param string $providerName
     * @return bool
     */
    public function hasProvider($providerName){
        if(isset($this->providers[$providerName]))
            return true;
        else
            return false;
    }
}