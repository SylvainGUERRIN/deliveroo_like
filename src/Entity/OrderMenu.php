<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderMenuRepository")
 */
class OrderMenu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="orderMenus")
     */
    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Menu", inversedBy="orderMenus")
     */
    private $menu;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return Order|null
     */
    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    /**
     * @param Order|null $orders
     * @return $this
     */
    public function setOrders(?Order $orders): self
    {
        $this->orders = $orders;
        return $this;
    }

    /**
     * @return Menu|null
     */
    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    /**
     * @param Menu|null $menu
     * @return $this
     */
    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;
        return $this;
    }
}
