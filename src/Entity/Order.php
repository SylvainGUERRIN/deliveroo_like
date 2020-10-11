<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $orderNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderedAt;

    /**
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", inversedBy="orders")
     */
    private $deliveryAddress;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     */
    private $consumer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderMenu", mappedBy="orders")
     */
    private $orderMenus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PaymentMethod", inversedBy="orders")
     */
    private $paymentMethod;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Restaurant", inversedBy="orders")
     */
    private $restaurants;

    public function __construct()
    {
        $this->restaurants = new ArrayCollection();
        $this->orderMenus = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    /**
     * @param mixed $orderNumber
     * @return $this
     */
    public function setOrderNumber($orderNumber): self
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderedAt(): ?\DateTimeInterface
    {
        return $this->orderedAt;
    }

    /**
     * @param mixed $orderedAt
     * @return $this
     */
    public function setOrderedAt(\DateTimeInterface $orderedAt): self
    {
        $this->orderedAt = $orderedAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    /**
     * @param mixed $totalPrice
     * @return $this
     */
    public function setTotalPrice($totalPrice): self
    {
        $this->totalPrice = $totalPrice;
        return $this;
    }

    /**
     * @return Address|null
     */
    public function getDeliveryAddress(): ?Address
    {
        return $this->deliveryAddress;
    }

    /**
     * @param Address|null $deliveryAddress
     * @return $this
     */
    public function setDeliveryAddress(?Address $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getConsumer(): ?User
    {
        return $this->consumer;
    }

    /**
     * @param User|null $consumer
     * @return $this
     */
    public function setConsumer(?User $consumer): self
    {
        $this->consumer = $consumer;
        return $this;
    }

    /**
     * @return Collection|OrderMenu[]
     */
    public function getOrderMenus(): Collection
    {
        return $this->orderMenus;
    }

    /**
     * @param OrderMenu $orderMenu
     * @return $this
     */
    public function addOrderMenu(OrderMenu $orderMenu): self
    {
        if (!$this->orderMenus->contains($orderMenu)) {
            $this->orderMenus[] = $orderMenu;
            $orderMenu->setOrders($this);
        }
        return $this;
    }

    /**
     * @param OrderMenu $orderMenu
     * @return $this
     */
    public function removeOrderMenu(OrderMenu $orderMenu): self
    {
        if ($this->orderMenus->contains($orderMenu)) {
            $this->orderMenus->removeElement($orderMenu);
            // set the owning side to null (unless already changed)
            if ($orderMenu->getOrders() === $this) {
                $orderMenu->setOrders(null);
            }
        }
        return $this;
    }

    /**
     * @return PaymentMethod|null
     */
    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    /**
     * @param PaymentMethod|null $paymentMethod
     * @return $this
     */
    public function setPaymentMethod(?PaymentMethod $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    /**
     * @return Collection|Restaurant[]
     */
    public function getRestaurants(): Collection
    {
        return $this->restaurants;
    }

    /**
     * @param Restaurant $restaurant
     * @return $this
     */
    public function addRestaurant(Restaurant $restaurant): self
    {
        if (!$this->restaurants->contains($restaurant)) {
            $this->restaurants[] = $restaurant;
        }
        return $this;
    }

    /**
     * @param Restaurant $restaurant
     * @return $this
     */
    public function removeRestaurant(Restaurant $restaurant): self
    {
        if ($this->restaurants->contains($restaurant)) {
            $this->restaurants->removeElement($restaurant);
        }
        return $this;
    }
}
