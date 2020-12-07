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
use Doctrine\ORM\Query\ResultSetMapping;

use Acme\ApiBundle\Entity\ItemOrder;
use Acme\ApiBundle\Entity\ShipTo;
use Acme\ApiBundle\Entity\PersonOrder;
use Acme\ApiBundle\Entity\ShipOrder;

class ShipOrderController extends Controller
{

    public function __contruct()
    {
        $request = Request::createFromGlobals();
    }

    public function xtractXmlShipOrderAction()
    {
        try{
            $path = self::upload();
            $array = self::decode($path);
            self::toShipOrder($array);
            return self::msg();
        }catch (Exception $e) {
            throw new Exception( $e->getMessage());
        }
    }

    public function getPerson($id)
    {
        try{
            $person = $this->getDoctrine()
                ->getRepository(PersonOrder::class)
                ->find($id);
            return  $person;
        }catch (Exception $e) {
            throw new Exception( $e->getMessage());
        }
    }

    public function toShipOrder($arrayPath)
    {
        try{
            foreach($arrayPath as $array )
            {   
                foreach($array as $model )
                {   
                    if(is_array($model)){
                        $shiporder = new ShipOrder;
                        $shiporder->setOrderid( $model['orderid'])
                                    ->setPersonid(self::getPerson($model['orderperson']));
                        $shiporder =  self::populate($shiporder);
                        $shipto = new ShipTo;
                        $shipto->setName($model['shipto']['name'])
                            ->setAddress($model['shipto']['address'])
                            ->setCountry($model['shipto']['city']) 
                                ->setOrderid( $shiporder) 
                            ->setCity($model['shipto']['country'])   ;
                    self::populate( $shipto);
                        self::itemsToArray( $model['items'],$shiporder );
                    
                    }else{
                        var_dump($model);
                        echo "nãoe e array";
                    }
                }
            }
        }catch (Exception $e) {
            throw new Exception( $e->getMessage());
        }
    }

    public function itemsToArray($array,$shiporder)
    {
        try{
            foreach($array as $model )
            { 
                if(array_key_exists('title',$model) ){
                    $itemOrder = new ItemOrder;
                    $itemOrder->setTitle($model['title'])
                        ->setQuantity($model['quantity'])
                        ->setPrice($model['price'])
                        ->setNote($model['note'])
                        ->setShiporderId($shiporder);
                        self::populate( $itemOrder);
                }
            }
        }catch (Exception $e) {
            throw new Exception( $e->getMessage());
        }
    }

    public function msg()
    {
        $response = new Response( 'OK', Response::HTTP_OK,['content-type' => 'text/html']);
        return $response;
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

    public function getAllAction()
    {
        $sql = " SELECT * FROM  ShipOrder as s 
            ";
        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
    
       $model=$stmt->fetchAll(); 
       $json=[];
        foreach($model as $md){
            $md['personorder']=self::getPersonOrder($md['personid']);
            $md['phone']=self::getPhone($md['personid']);
            $md['items']=self::getItems($md['orderid']);
            $md['shipto']=self::getShipTo($md['orderid']);
            $json[]= $md;
        }
        $normalizer = new ObjectNormalizer();
        $encoder = new JsonEncoder();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $json=$serializer->serialize($json, 'json'); 
        return new Response($json);
    }

    public function getPhone($id)
    {
        $sql = " SELECT * FROM  Phone WHERE person_id=".$id;
        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getItems($id)
    {
        $sql = " SELECT * FROM  ItemOrder WHERE shiporder_id=".$id;
        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getPersonOrder($id)
    {
        $sql = " SELECT * FROM  PersonOrder WHERE personid=".$id;
        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getShipTo($id)
    {
        $sql = " SELECT * FROM  ShipTo WHERE order_id=".$id;
        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
