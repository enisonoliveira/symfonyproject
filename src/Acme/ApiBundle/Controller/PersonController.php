<?php

namespace Acme\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Acme\ApiBundle\Entity\PersonOrder;
use Acme\ApiBundle\Entity\Phone;

class PersonController extends Controller
{

    public function __contruct()
    {
        $request = Request::createFromGlobals();
    }

    public function xtractXmlPersonAction()
    {
       $path = self::upload();
        $array = self::decode($path);
        self::toPersonArray($array['person']);
        return self::msg();
    }

    public function decode($path)
    {
        $xml=simplexml_load_string(file_get_contents($path));
        $json = json_encode($xml);
        return json_decode($json,TRUE);
    }

    public function upload()
    {
        $name=time().'.xml';
        $webPath = $this->get('kernel')->getRootDir() . '/../web/uploads/';
        $this->getRequest()->files->get('file')->move($webPath, $name);
        return $webPath.$name;

    }

    public function populate($object)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
        $em->flush();
        return $object;
    }

    public function toPersonArray($persons)
    {
        foreach($persons as $model)
        {
            $person = new PersonOrder;
            $person->setPersonId($model['personid']);
            $person->setPersonname($model['personname']);
            $person = self::populate($person);
           self::phone( $model['phones']['phone'],$person);
        }

    }

    public function phone($phons,$person)
    {
        if (is_array($phons) || is_object($phons))
        {
             foreach( $phons as $pk => $value)
            {
                
                $phone = new Phone;
                $phone->setPhone($value)
                    ->setPersonid($person);
                self::populate($phone);
            }
        }
    }

    public function msg()
    {
        $response = new Response( 'ok', Response::HTTP_OK,['content-type' => 'text/html']);
        return $response;
    }
}
