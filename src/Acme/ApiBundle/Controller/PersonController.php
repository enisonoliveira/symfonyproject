<?php

namespace Acme\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
        try {
            $path = self::upload();
            $array = self::decode($path);
            self::toPersonArray($array['person']);
            return self::msg();
        }catch (Exception $e) {
            throw new Exception( $e->getMessage());
        }
    }

    public function decode($path)
    {
        try{
            $xml=simplexml_load_string(file_get_contents($path));
            $json = json_encode($xml);
            return json_decode($json,TRUE);
        }catch (Exception $e) {
            throw new Exception( $e->getMessage());
        }
    }

    public function upload()
    {
        try{
            $name=time().'.xml';
            $webPath = $this->get('kernel')->getRootDir() . '/../web/uploads/';
            $this->getRequest()->files->get('file')->move($webPath, $name);
            return $webPath.$name;
        }catch (Exception $e) {
            throw new Exception( $e->getMessage());
        }
    }

    public function populate($object)
    {
        try{
            $em = $this->getDoctrine()->getManager();
            $em->persist($object);
            $em->flush();
            return $object;
        }catch (Exception $e) {
            throw new Exception( $e->getMessage());
        }
    }

    public function toPersonArray($persons)
    {
        try{
            foreach($persons as $model)
            {
                $person = new PersonOrder;
                $person->setPersonId($model['personid']);
                $person->setPersonname($model['personname']);
                $person = self::populate($person);
            self::phone( $model['phones']['phone'],$person);
            }
        }catch (Exception $e) {
            throw new Exception( $e->getMessage());
        }
    }

    public function phone($phons,$person)
    {
        try{
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
        }catch (Exception $e) {
            throw new Exception( $e->getMessage());
        }
    }

    public function msg()
    {
        $response = new Response( 'ok', Response::HTTP_OK,['content-type' => 'text/html']);
        return $response;
    }

    public function getAllAction()
    {
        $repository = $this->getDoctrine()->getRepository(PersonOrder::class);
        $persons = $repository->findAll();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($persons) {
            return $persons->getPersonid();
        });

        $encoder = new JsonEncoder();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $json=$serializer->serialize($persons, 'json'); 
        return new Response($json);
    }
}
