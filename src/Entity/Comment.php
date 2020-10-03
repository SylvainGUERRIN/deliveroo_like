<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $commentedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     */
    private $commentedBy;

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
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentedAt(): ?\DateTimeInterface
    {
        return $this->commentedAt;
    }

    /**
     * @param mixed $commentedAt
     * @return $this
     */
    public function setCommentedAt(\DateTimeInterface $commentedAt): self
    {
        $this->commentedAt = $commentedAt;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getCommentedBy(): ?User
    {
        return $this->commentedBy;
    }

    /**
     * @param User|null $commentedBy
     * @return $this
     */
    public function setCommentedBy(?User $commentedBy): self
    {
        $this->commentedBy = $commentedBy;

        return $this;
    }
}
