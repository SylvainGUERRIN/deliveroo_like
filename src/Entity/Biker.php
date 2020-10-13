<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BikerRepository")
 */
class Biker
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
    private $enterpriseCode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $RightToCreateEnterprise;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthdayDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sponsorship;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $iban;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $transportation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="bikers")
     */
    private $cityWorkWith;

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
    public function getEnterpriseCode(): ?string
    {
        return $this->enterpriseCode;
    }

    /**
     * @param mixed $enterpriseCode
     * @return $this
     */
    public function setEnterpriseCode($enterpriseCode): self
    {
        $this->enterpriseCode = $enterpriseCode;
        return $this;
    }

    /**
     * @return bool
     */
    public function getRightToCreateEnterprise(): ?bool
    {
        return $this->RightToCreateEnterprise;
    }

    /**
     * @param mixed $RightToCreateEnterprise
     * @return $this
     */
    public function setRightToCreateEnterprise($RightToCreateEnterprise): self
    {
        $this->RightToCreateEnterprise = $RightToCreateEnterprise;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthdayDate(): ?\DateTimeInterface
    {
        return $this->birthdayDate;
    }

    /**
     * @param mixed $birthdayDate
     * @return $this
     */
    public function setBirthdayDate(\DateTimeInterface $birthdayDate): self
    {
        $this->birthdayDate = $birthdayDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSponsorship(): ?string
    {
        return $this->sponsorship;
    }

    /**
     * @param mixed $sponsorship
     * @return $this
     */
    public function setSponsorship($sponsorship): self
    {
        $this->sponsorship = $sponsorship;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIban(): ?string
    {
        return $this->iban;
    }

    /**
     * @param mixed $iban
     * @return $this
     */
    public function setIban($iban): self
    {
        $this->iban = $iban;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransportation(): ?string
    {
        return $this->transportation;
    }

    /**
     * @param mixed $transportation
     * @return $this
     */
    public function setTransportation($transportation): self
    {
        $this->transportation = $transportation;
        return $this;
    }

    /**
     * @return City|null
     */
    public function getCityWorkWith(): ?City
    {
        return $this->cityWorkWith;
    }

    /**
     * @param City|null $city
     * @return $this
     */
    public function setCityWorkWith(?City $city): self
    {
        $this->cityWorkWith = $city;
        return $this;
    }
}
