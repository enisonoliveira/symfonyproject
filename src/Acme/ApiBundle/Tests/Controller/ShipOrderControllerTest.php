<?php

namespace Acme\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ShipOrderControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $path=__DIR__.'/shiporder.xml';
        $file = new UploadedFile(
            $path,
            'chiporder.xml',
            'text/xml',
            123
        );
        $client = static::createClient();
        $client->request(
            'POST',
            '/upload/shiporder',
            array('files' => 'xml'),
            array('file' => $file)
        );
        $response = $client->getResponse();
    }
}
