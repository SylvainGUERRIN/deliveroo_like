<?php

namespace App\Entity;

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
}
