<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 27.03.16
 * Time: 15:14
 */

namespace Syagr\CMSBundle\Tests\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Syagr\CMSBundle\Service\CustomFieldsService;
use Syagr\MediaBundle\Entity\Media;
use Syagr\MediaBundle\Service\MediaManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CustomFieldServiceTest  extends WebTestCase
{
    
    public function testProcessDataForSaving(){
        $client = static::createClient();
        $container = $client->getContainer();

        $em = $container->get('doctrine.orm.entity_manager');
        $mR = $em->getRepository('SyagrMediaBundle:Media');
        $media = $mR->findOneByName('test111.jpg');
        $this->assertEquals($media instanceof Media, true);

        $testJsonData = '{"id":7,"title":"eqwqwe","text":"<p>ewqwqeqwewqeeqw</p>","customs":{"boolean":false,"repeat":[{"wysiwyg":"<p>ewqewqeqweqw</p>","email":"syagrovskiyandriy@gmail.com"}],"file":{"media":{"id": '.$media->getId().'}}},"slug":"weqqewqewewq","style":"style1"}';
        $testData = json_decode($testJsonData, true);
        $config = [
            "file"  => ["type" => "file"],
            "repeat" => [
                "type" => "repeat",
                "fields" => [
                    "wysiwyg"  => ["type" => "wysiwyg"],
                    "email"  => ["type" => "email"],
                ]
            ],
        ];

        $customService = new CustomFieldsService($em);

        $result = $customService->processDataForSaving($testData['customs'], $config);

        $this->assertArrayHasKey("file", $result);
        $this->assertEquals($result['file'], 1);
        $this->assertArrayHasKey("repeat", $result);
        $this->assertEquals(is_array($result['repeat']), true);
    }

    public function testProcessDataForLoading(){
        $client = static::createClient();
        $container = $client->getContainer();

        $em = $container->get('doctrine.orm.entity_manager');
        $mR = $em->getRepository('SyagrMediaBundle:Media');
        $mediaManager = new MediaManager($em);

        $testData = [
            'file' => $mR->findOneByName('test111.jpg')->getId(),
            'repeat' => [
                'file2'   => $mR->findOneByName('test222.jpg')->getId(),
                'wysiwyg' => '<p></p>',
                'email'   => 'syagrovskiyandriy@gmail.com'
            ]
        ];

        $config = [
            "file"  => ["type" => "file"],
            "repeat" => [
                "type" => "repeat",
                "fields" => [
                    "wysiwyg"  => ["type" => "wysiwyg"],
                    "email"    => ["type" => "email"],
                    'file2'    => ["type" => "file"],
                ]
            ],
        ];

        $customService = new CustomFieldsService($em);
        $customService->setMediaManager($mediaManager);

        $result = $customService->processDataForLoading($testData, $config);
        dump($result);
    }
}