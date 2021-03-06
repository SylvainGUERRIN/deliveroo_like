<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
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
     * @ORM\Column(type="integer")
     */
    private $zipCode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Address", mappedBy="city")
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Restaurant", mappedBy="city")
     */
    private $restaurants;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Biker", mappedBy="cityWorkWith")
     */
    private $bikers;

    /**
     * City constructor.
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
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
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     * @return $this
     */
    public function setZipCode($zipCode): self
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param Address $address
     * @return $this
     */
    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setCity($this);
        }
        return $this;
    }

    /**
     * @param Address $address
     * @return $this
     */
    public function removeAddress(Address $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getCity() === $this) {
                $address->setCity(null);
            }
        }
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
            $restaurant->setCity($this);
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
            // set the owning side to null (unless already changed)
            if ($restaurant->getCity() === $this) {
                $restaurant->setCity(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Restaurant[]
     */
    public function getBikers(): Collection
    {
        return $this->bikers;
    }

    /**
     * @param Biker $biker
     * @return $this
     */
    public function addBiker(Biker $biker): self
    {
        if (!$this->bikers->contains($biker)) {
            $this->bikers[] = $biker;
            $biker->setCity($this);
        }
        return $this;
    }

    /**
     * @param Biker $biker
     * @return $this
     */
    public function removeBiker(Biker $biker): self
    {
        if ($this->bikers->contains($biker)) {
            $this->bikers->removeElement($biker);
            // set the owning side to null (unless already changed)
            if ($biker->getCity() === $this) {
                $biker->setCity(null);
            }
        }
        return $this;
    }
}
