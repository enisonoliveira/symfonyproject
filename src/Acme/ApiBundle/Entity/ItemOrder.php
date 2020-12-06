<?php

namespace Acme\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemOrder
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ItemOrder
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $iditemorder;

    
    /**
     * @ORM\ManyToOne(targetEntity="\Acme\ApiBundle\Entity\ShipOrder", inversedBy="itemsorder")
     * @ORM\JoinColumn(name="shiporder_id", referencedColumnName="orderid")
     */
    protected $shiporder;

    /**
     * @var text
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var text
     * @ORM\Column(name="note", type="text")
     */
    private $note;

     /**
     * @var float
     * @ORM\Column(name="quantity", type="float")
     */
    private $quantity;

     /**
     * @var decimal
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $price;


    /**
     * Get iditemorder
     *
     * @return integer 
     */
    public function getIditemorder()
    {
        return $this->iditemorder;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ItemOrder
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return ItemOrder
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set quantity
     *
     * @param float $quantity
     * @return ItemOrder
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return float 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return ItemOrder
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set shiporder
     *
     * @param \Acme\ApiBundle\Entity\ShipOrder $shiporder
     * @return ItemOrder
     */
    public function setShiporder(\Acme\ApiBundle\Entity\ShipOrder $shiporder = null)
    {
        $this->shiporder = $shiporder;
    
        return $this;
    }

    /**
     * Get shiporder
     *
     * @return \Acme\ApiBundle\Entity\ShipOrder 
     */
    public function getShiporder()
    {
        return $this->shiporder;
    }
}