<?php

namespace Acme\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PersonControllerTest extends WebTestCase
{
    public function testIndex()
    {

       $path=__DIR__.'/personorder.xml';
        $file = new UploadedFile(
            $path,
            'person.xml',
            'text/xml',
            123
        );
        $client = static::createClient();
        $client->request(
            'POST',
            '/upload/person',
            array('files' => 'xml'),
            array('file' => $file)
        );
        $response = $client->getResponse();
    }
}
