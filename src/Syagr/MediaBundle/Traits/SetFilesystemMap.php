<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 07.03.16
 * Time: 23:30
 */

namespace Syagr\MediaBundle\Traits;
use Gaufrette\FilesystemMap;

trait SetFilesystemMap
{
    /**
     * @var FilesystemMap
     */
    protected $filesystemMap;

    /**
     * @param  $filesystemMap
     * @return $this
     */
    public function setFilesystemMap($filesystemMap)
    {
        $this->filesystemMap = $filesystemMap;

        return $this;
    }
}