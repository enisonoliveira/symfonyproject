<?php

namespace Acme\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShipTo
 * @ORM\Table()
 * @ORM\Entity
 */
class ShipTo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Acme\ApiBundle\Entity\ShipOrder", inversedBy="itemsorder")
     * @ORM\JoinColumn(name="orderid", referencedColumnName="orderid")
     */
    private $orderid;

     /**
     * @var text
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var text
     * @ORM\Column(name="address", type="text")
     */
    private $address;

    /**
     * @var text
     * @ORM\Column(name="city", type="text")
     */
    private $city;

     /**
     * @var text
     * @ORM\Column(name="country", type="text")
     */
    private $country;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ShipTo
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return ShipTo
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return ShipTo
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return ShipTo
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set orderid
     *
     * @param \Acme\ApiBundle\Entity\ShipOrder $orderid
     * @return ShipTo
     */
    public function setOrderid(\Acme\ApiBundle\Entity\ShipOrder $orderid = null)
    {
        $this->orderid = $orderid;
    
        return $this;
    }

    /**
     * Get orderid
     *
     * @return \Acme\ApiBundle\Entity\ShipOrder 
     */
    public function getOrderid()
    {
        return $this->orderid;
    }
}