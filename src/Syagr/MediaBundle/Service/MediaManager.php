<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 21.02.16
 * Time: 22:58
 */

namespace Syagr\MediaBundle\Service;

use Syagr\CMSBundle\Service\ResponseAbleManager;
use Syagr\MediaBundle\Traits\SetContextServiceTrait;
use Syagr\MediaBundle\Traits\SetProviderServiceTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Syagr\CMSBundle\Exception\ManagerException;
use Syagr\MediaBundle\Entity\Media;

class MediaManager extends  ResponseAbleManager
{
    use SetContextServiceTrait;
    use SetProviderServiceTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * @param UploadedFile $file
     * @param string $context
     * @param string $provider
     */
    function addToMedia(UploadedFile $file, $context, $provider){
        $media = new Media();
        $media->setFileName($this->saveFile($file, $context, $provider));
        $media->setName($file->getClientOriginalName());
        $media->setProviderName($provider);
        $media->setProviderMetadata(array('filename' => $file->getClientOriginalName()));
        $media->setContentType($file->getMimeType());
        $media->setSize($file->getSize());
        $media->setContextName($context);
        $this->em->persist($media);
        $this->em->flush();

        return ['media' => $media, 'url' => $this->getMediaUrl($media)];
    }

    /**
     * @param UploadedFile $file
     * @param $context
     * @param $provider
     * @return string
     * @throws ManagerException
     */
    function saveFile(UploadedFile $file, $context, $provider){
        $fileName = sprintf('%s/%s/%s/%s/%s.%s', $context, date('Y'), date('m'), date('d'),  md5(uniqid()), $file->guessExtension());

        if(!$contextInstance = $this->contextService->getContext($context))
            throw new ManagerException(sprintf('The context "%s" is not found', $context));

        if(!$providerInstance = $contextInstance->getProvider($provider))
            throw new ManagerException(sprintf('The provider "%s" is not found in the context "%s"', $provider, $context));

        if(!$providerInstance->isAllowedMimeType($file->getClientMimeType()))
            throw new ManagerException(sprintf('The mime type "%s" is not allowed for provider %s', $file->getClientMimeType(), $provider));

        if(!$providerInstance->isAllowedFilesExtension($file->guessExtension()))
            throw new ManagerException(sprintf('The file extension "%s" is not allowed for provider %s', $file->guessExtension(), $provider));

        $providerInstance->getFilesystem()->write($fileName, file_get_contents($file->getPathname()));
        return $fileName;
    }

    function getMediaUrl($media){
        return $this->providerService->getProviderFilesystemName($media->getProviderName()).'/'.$media->getFileName();
    }
}