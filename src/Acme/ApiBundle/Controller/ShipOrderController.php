<?php

namespace Acme\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $path = self::upload();
        $array = self::decode($path);
        self::toShipOrder($array);
        return self::msg();
    }

    public function getPerson($id)
    {
        $person = $this->getDoctrine()
            ->getRepository(PersonOrder::class)
            ->find($id);
        return  $person;
    }

    public function toShipOrder($arrayPath)
    {
        foreach($arrayPath as $array )
        {   
            foreach($array as $model )
            {   
                if(is_array($model)){
                    $shiporder = new ShipOrder;
                    $shiporder->shipOderid( $model['orderid'])
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
    }

    public function itemsToArray($array,$shiporder)
    {
        foreach($array as $model )
        { 
            if(array_key_exists('title',$model) ){
                $itemOrder = new ItemOrder;
                $itemOrder->setTitle($model['title'])
                    ->setQuantity($model['quantity'])
                    ->setPrice($model['price'])
                    ->setNote($model['note'])
                    ->setShiporder($shiporder);
                    self::populate( $itemOrder);
            }

         }

    }

    public function msg()
    {
        $response = new Response( 'OK', Response::HTTP_OK,['content-type' => 'text/html']);
        return $response;
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

}
