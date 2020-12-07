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
     * @ORM\OneToMany(targetEntity="ItemOrder", mappedBy="shiporder_id")
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
     * Set orderid
     *
     * @param integer $orderid
     *
     * @return ShipOrder
     */
    public function setOrderid($orderid)
    {
        $this->orderid = $orderid;

        return $this;
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
     *
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
     * Add item
     *
     * @param \Acme\ApiBundle\Entity\ItemOrder $item
     *
     * @return ShipOrder
     */
    public function addItem(\Acme\ApiBundle\Entity\ItemOrder $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \Acme\ApiBundle\Entity\ItemOrder $item
     */
    public function removeItem(\Acme\ApiBundle\Entity\ItemOrder $item)
    {
        $this->items->removeElement($item);
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
