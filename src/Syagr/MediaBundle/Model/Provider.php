<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 07.03.16
 * Time: 21:47
 */

namespace Syagr\MediaBundle\Model;

use Gaufrette\Filesystem;

class Provider
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * array
     */
    protected $allowedMimeTypes;

    /**
     * array
     */
    protected $allowedFilesExtensions;

    /**
     * Context constructor.
     * @param string $name
     * @param Filesystem $filesystem
     * @param array $allowedMimeTypes
     * @param array $allowedFilesExtensions
     */
    public function __construct($name, Filesystem $filesystem, array $allowedMimeTypes = [], array $allowedFilesExtensions = [])
    {
        $this->name       = $name;
        $this->filesystem = $filesystem;
        $this->allowedMimeTypes       = $allowedMimeTypes;
        $this->allowedFilesExtensions = $allowedFilesExtensions;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $mimeType
     * @return bool
     */
    public function isAllowedMimeType($mimeType){
        return in_array($mimeType, $this->allowedMimeTypes);
    }

    /**
     * @param string $extension
     * @return bool
     */
    public function isAllowedFilesExtension($extension){
        return in_array($extension, $this->allowedFilesExtensions);
    }

    /**
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }
}