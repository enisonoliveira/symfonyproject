<?php

namespace Acme\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShipOrder
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ShipOrder
{
    /**
     * @var integer
     *
     * @ORM\Column(name="orderid", type="integer")
     * @ORM\Id
     */
    private $orderid;


    /**
     * @ORM\ManyToOne(targetEntity="\Acme\ApiBundle\Entity\PersonOrder", inversedBy="shiporderperson")
     * @ORM\JoinColumn(name="personid", referencedColumnName="personid")
     */
    private $personid;


    /**
     * @ORM\OneToMany(targetEntity="ItemOrder", mappedBy="shiporderitem")
     */

    protected $items;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get orderid
     *
     * @return integer 
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * Set personid
     *
     * @param \Acme\ApiBundle\Entity\PersonOrder $personid
     * @return ShipOrder
     */
    public function setPersonid(\Acme\ApiBundle\Entity\PersonOrder $personid = null)
    {
        $this->personid = $personid;
    
        return $this;
    }

    /**
     * Get personid
     *
     * @return \Acme\ApiBundle\Entity\PersonOrder 
     */
    public function getPersonid()
    {
        return $this->personid;
    }

    /**
     * Set shipoderid
     *
     * @param string $shipoderid
     * @return PeopleOrders
     */
    public function shipOderid($orderid)
    {
        $this->orderid = $orderid;
    
        return $this;
    }

    /**
     * Add items
     *
     * @param \Acme\ApiBundle\Entity\ItemOrder $items
     * @return ShipOrder
     */
    public function addItem(\Acme\ApiBundle\Entity\ItemOrder $items)
    {
        $this->items[] = $items;
    
        return $this;
    }

    /**
     * Remove items
     *
     * @param \Acme\ApiBundle\Entity\ItemOrder $items
     */
    public function removeItem(\Acme\ApiBundle\Entity\ItemOrder $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }
}