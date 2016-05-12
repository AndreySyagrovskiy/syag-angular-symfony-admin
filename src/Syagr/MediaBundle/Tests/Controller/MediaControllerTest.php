<?php

namespace Syagr\MediaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaControllerTest extends WebTestCase
{
    public function testUpload()
    {
        $client = static::createClient();
        $file = new UploadedFile(
            __DIR__.'/test.jpeg',
            'test.jpeg',
            'image/jpeg'
        );


        $crawler = $client->request(
            'POST',
            '/upload',
            [],
            ["file" => $file]
        );

        dump($client->getResponse()->getContent());
    }
}
