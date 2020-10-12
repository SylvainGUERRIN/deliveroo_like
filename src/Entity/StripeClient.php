<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StripeClientRepository")
 */
class StripeClient
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
    private $accountId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stripePublishableKey;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Restaurant", cascade={"persist", "remove"})
     */
    private $restaurant;

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
    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    /**
     * @param string $accountId
     * @return $this
     */
    public function setAccountId(string $accountId): self
    {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStripePublishableKey(): ?string
    {
        return $this->stripePublishableKey;
    }

    /**
     * @param string $stripePublishableKey
     * @return $this
     */
    public function setStripePublishableKey(string $stripePublishableKey): self
    {
        $this->stripePublishableKey = $stripePublishableKey;
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
