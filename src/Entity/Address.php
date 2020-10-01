<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
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
     * @ORM\Column(type="string", length=255)
     */
    private $line1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $line2;

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
    public function getLine1(): ?string
    {
        return $this->line1;
    }

    /**
     * @param mixed $line1
     * @return $this
     */
    public function setLine1($line1): self
    {
        $this->line1 = $line1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLine2(): ?string
    {
        return $this->line2;
    }

    /**
     * @param mixed $line2
     * @return $this
     */
    public function setLine2($line2): self
    {
        $this->line2 = $line2;
        return $this;
    }


}
