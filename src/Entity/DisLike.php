<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DisLikeRepository")
 */
class DisLike
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $disliked_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="disLikes")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="disLikes")
     */
    private $target;

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
    public function getDislikedAt(): ?\DateTimeInterface
    {
        return $this->disliked_at;
    }

    /**
     * @param mixed $disliked_at
     * @return $this
     */
    public function setDislikedAt(\DateTimeInterface $disliked_at): self
    {
        $this->disliked_at = $disliked_at;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Restaurant|null
     */
    public function getTarget(): ?Restaurant
    {
        return $this->target;
    }

    /**
     * @param Restaurant|null $target
     * @return $this
     */
    public function setTarget(?Restaurant $target): self
    {
        $this->target = $target;
        return $this;
    }
}
