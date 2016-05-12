<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 09.01.16
 * Time: 12:45
 */

namespace Syagr\CMSBundle\Traits;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


trait SetSecurityEncoderFactoryTrait
{
    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * @param EncoderFactoryInterface $encoderFactory
     * @return $this
     */
    public function setEncoderFactory(EncoderFactoryInterface $encoderFactory){
        $this->encoderFactory = $encoderFactory;

        return $this;
    }
}