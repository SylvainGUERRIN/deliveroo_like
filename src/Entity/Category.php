<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="categories")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Menu", mappedBy="category")
     */
    private $menus;

//    /**
//     * @ORM\ManyToMany(targetEntity="App\Entity\Restaurant", mappedBy="categories")
//     */
//    private $restaurants;

    /**
     * @ORM\OneToMany(targetEntity=Restaurant::class, mappedBy="category")
     */
    private $restaurant;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->restaurant = new ArrayCollection();
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
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
            $menu->setCategory($this);
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
            if ($menu->getCategory() === $this) {
                $menu->setCategory(null);
            }
        }
        return $this;
    }

//    /**
//     * @return Collection|Restaurant[]
//     */
//    public function getRestaurants(): Collection
//    {
//        return $this->restaurants;
//    }

//    /**
//     * @param Restaurant $restaurant
//     * @return $this
//     */
//    public function addRestaurant(Restaurant $restaurant): self
//    {
//        if (!$this->restaurants->contains($restaurant)) {
//            $this->restaurants[] = $restaurant;
//            $restaurant->addCategory($this);
//        }
//        return $this;
//    }
//
//    /**
//     * @param Restaurant $restaurant
//     * @return $this
//     */
//    public function removeRestaurant(Restaurant $restaurant): self
//    {
//        if ($this->restaurants->contains($restaurant)) {
//            $this->restaurants->removeElement($restaurant);
//            $restaurant->removeCategory($this);
//        }
//        return $this;
//    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->name;
    }

    /**
     * @return Collection|Restaurant[]
     */
    public function getRestaurant(): Collection
    {
        return $this->restaurant;
    }
}
