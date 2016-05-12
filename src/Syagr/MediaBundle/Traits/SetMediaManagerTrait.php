<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 03.04.16
 * Time: 15:47
 */

namespace Syagr\MediaBundle\Traits;

use Syagr\MediaBundle\Service\MediaManager;

trait SetMediaManagerTrait
{
    /**
     * @var MediaManager
     */
    protected $mediaManager;

    public function setMediaManager(MediaManager $mediaManager){
        $this->mediaManager = $mediaManager;
    }
}