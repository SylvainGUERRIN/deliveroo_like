<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 */
class Restaurant
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
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(type="time")
     */
    private $opensAt;

    /**
     * @ORM\Column(type="time")
     */
    private $closesAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="owners", cascade={"persist", "remove"})
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="managedRestaurant")
     */
    private $managers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DisLike", mappedBy="target")
     */
    private $disLikes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Like", mappedBy="target")
     */
    private $likes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Order", mappedBy="restaurants")
     */
    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="restaurants")
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Menu", mappedBy="restaurant")
     */
    private $menus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", inversedBy="restaurants", cascade={"persist"})
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\StripeClient", cascade={"persist", "remove"})
     */
    private $stripeClient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $siren;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $delivery;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="restaurant")
     */
    private $category;

    /**
     * Restaurant constructor.
     */
    public function __construct()
    {
        $this->managers = new ArrayCollection();
        $this->disLikes = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

    /**
     * @return int|null
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
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string|null $number
     * @return $this
     */
    public function setNumber(?string $number): self
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getOpensAt(): ?\DateTimeInterface
    {
        return $this->opensAt;
    }

    /**
     * @param \DateTimeInterface $opensAt
     * @return $this
     */
    public function setOpensAt(\DateTimeInterface $opensAt): self
    {
        $this->opensAt = $opensAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getClosesAt(): ?\DateTimeInterface
    {
        return $this->closesAt;
    }

    /**
     * @param \DateTimeInterface $closesAt
     * @return $this
     */
    public function setClosesAt(\DateTimeInterface $closesAt): self
    {
        $this->closesAt = $closesAt;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return $this
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * voter verifications
     * @return bool
     */
    public function isEnabled(): ?bool
    {
        if ($this->enabled)
        {
            return true;
        }

        return false;
    }

    /**
     * @return bool|null
     */
    public function getPublished(): ?bool
    {
        return $this->published;
    }

    /**
     * @param bool $published
     * @return $this
     */
    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface|null $createdAt
     * @return $this
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

//    /**
//     * @return Collection|Category[]
//     */
//    public function getCategories(): Collection
//    {
//        return $this->categories;
//    }
//
//    /**
//     * @param Category $category
//     * @return $this
//     */
//    public function addCategory(Category $category): self
//    {
//        if (!$this->categories->contains($category)) {
//            $this->categories[] = $category;
//        }
//        return $this;
//    }
//
//    /**
//     * @param Category $category
//     * @return $this
//     */
//    public function removeCategory(Category $category): self
//    {
//        if ($this->categories->contains($category)) {
//            $this->categories->removeElement($category);
//        }
//        return $this;
//    }

    /**
     * @return User|null
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * @param User|null $owner
     * @return $this
     */
    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getManagers(): Collection
    {
        return $this->managers;
    }

    /**
     * @param User $manager
     * @return $this
     */
    public function addManager(User $manager): self
    {
        if (!$this->managers->contains($manager)) {
            $this->managers[] = $manager;
            $manager->setManagedRestaurant($this);
        }

        return $this;
    }

    /**
     * @param User $manager
     * @return $this
     */
    public function removeManager(User $manager): self
    {
        if ($this->managers->contains($manager)) {
            $this->managers->removeElement($manager);
            // set the owning side to null (unless already changed)
            if ($manager->getManagedRestaurant() === $this) {
                $manager->setManagedRestaurant(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|DisLike[]
     */
    public function getDisLikes(): Collection
    {
        return $this->disLikes;
    }

    /**
     * @param DisLike $disLike
     * @return $this
     */
    public function addDisLike(DisLike $disLike): self
    {
        if (!$this->disLikes->contains($disLike)) {
            $this->disLikes[] = $disLike;
            $disLike->setTarget($this);
        }

        return $this;
    }

    /**
     * @param DisLike $disLike
     * @return $this
     */
    public function removeDisLike(DisLike $disLike): self
    {
        if ($this->disLikes->contains($disLike)) {
            $this->disLikes->removeElement($disLike);
            // set the owning side to null (unless already changed)
            if ($disLike->getTarget() === $this) {
                $disLike->setTarget(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    /**
     * @param Like $like
     * @return $this
     */
    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setTarget($this);
        }

        return $this;
    }

    /**
     * @param Like $like
     * @return $this
     */
    public function removeLike(Like $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getTarget() === $this) {
                $like->setTarget(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addRestaurant($this);
        }

        return $this;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            $order->removeRestaurant($this);
        }
        return $this;
    }

    /**
     * @return City|null
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @param City|null $city
     * @return $this
     */
    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    /**
     * @param Menu $menu
     * @return $this
     */
    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setRestaurant($this);
        }

        return $this;
    }

    /**
     * @param Menu $menu
     * @return $this
     */
    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->contains($menu)) {
            $this->menus->removeElement($menu);
            // set the owning side to null (unless already changed)
            if ($menu->getRestaurant() === $this) {
                $menu->setRestaurant(null);
            }
        }
        return $this;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address|null $address
     * @return $this
     */
    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return StripeClient|null
     */
    public function getStripeClient(): ?StripeClient
    {
        return $this->stripeClient;
    }

    /**
     * @param StripeClient|null $stripeClient
     * @return $this
     */
    public function setStripeClient(?StripeClient $stripeClient): self
    {
        $this->stripeClient = $stripeClient;
        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(string $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
