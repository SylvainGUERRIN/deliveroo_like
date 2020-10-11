<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 */
class Menu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CartItem", mappedBy="menu")
     */
    private $cartItems;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="menus")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="menus")
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Comment", mappedBy="targetMenu")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderMenu", mappedBy="menu")
     */
    private $orderMenus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="menus")
     */
    private $restaurant;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
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
            $cartItem->setMenu($this);
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
            if ($cartItem->getMenu() === $this) {
                $cartItem->setMenu(null);
            }
        }
        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return $this
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return Image|null
     */
    public function getImage(): ?Image
    {
        return $this->image;
    }

    /**
     * @param Image|null $image
     * @return $this
     */
    public function setImage(?Image $image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->addTargetMenu($this);
        }

        return $this;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            $comment->removeTargetMenu($this);
        }
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
            $orderMenu->setMenu($this);
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
            if ($orderMenu->getMenu() === $this) {
                $orderMenu->setMenu(null);
            }
        }
        return $this;
    }

    /**
     * @return Restaurant|null
     */
    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    /**
     * @param Restaurant|null $restaurant
     * @return $this
     */
    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;
        return $this;
    }
}
