<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartItemRepository")
 */
class CartItem
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Cart", inversedBy="cartItems")
     */
    private $cart;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Menu", inversedBy="cartItems")
     */
    private $menu;

    /**
     * @return mixed
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
     * @return Cart|null
     */
    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    /**
     * @param Cart|null $cart
     * @return $this
     */
    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;
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
