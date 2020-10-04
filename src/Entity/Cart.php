<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="cart", cascade={"persist", "remove"})
     */
    private $consumer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CartItem", mappedBy="cart")
     */
    private $cartItems;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|CartItem[]
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    /**
     * @param CartItem $cartItem
     * @return $this
     */
    public function addCartItem(CartItem $cartItem): self
    {
        if (!$this->cartItems->contains($cartItem)) {
            $this->cartItems[] = $cartItem;
            $cartItem->setCart($this);
        }
        return $this;
    }

    /**
     * @param CartItem $cartItem
     * @return $this
     */
    public function removeCartItem(CartItem $cartItem): self
    {
        if ($this->cartItems->contains($cartItem)) {
            $this->cartItems->removeElement($cartItem);
            // set the owning side to null (unless already changed)
            if ($cartItem->getCart() === $this) {
                $cartItem->setCart(null);
            }
        }
        return $this;
    }
}
