<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 02.04.16
 * Time: 20:34
 */

namespace Syagr\MediaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Doctrine\Common\Persistence\ObjectManager;

use Syagr\MediaBundle\Entity\Media;
use Syagr\MediaBundle\Service\MediaManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class LoadMediaData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        /**
         * @var MediaManager
         */
        $mediaService = $this->container->get('syagr_media.media_manager');

        $file1 = new UploadedFile(
            __DIR__.'/files/test1.jpg',
            'test111.jpg',
            'image/jpeg'
        );
        $file2 = new UploadedFile(
            __DIR__.'/files/test2.jpg',
            'test222.jpg',
            'image/jpeg'
        );
        $fileName1 = $mediaService->saveFile($file1, 'default', 'file');
        $fileName2 = $mediaService->saveFile($file2, 'default', 'file');

        $media1 = new Media();
        $media1->setContextName('default');
        $media1->setProviderName('file');
        $media1->setProviderMetadata(array('filename' => $file1->getClientOriginalName()));
        $media1->setContentType($file1->getMimeType());
        $media1->setSize($file1->getSize());
        $media1->setFileName($fileName1);
        $media1->setName($file1->getClientOriginalName());
        $manager->persist($media1);

        $media2 = new Media();
        $media2->setContextName('default');
        $media2->setProviderName('file');
        $media2->setProviderMetadata(array('filename' => $file2->getClientOriginalName()));
        $media2->setContentType($file2->getMimeType());
        $media2->setSize($file2->getSize());
        $media2->setFileName($fileName2);
        $media2->setName($file2->getClientOriginalName());
        $manager->persist($media2);

        $manager->flush();

    }

    public function getOrder()
    {
        return 1;
    }

}