<?php


namespace App\Entity;

use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Menu", inversedBy="comments")
     */
    private $targetMenu;

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

    /**
     * @return Collection|Menu[]
     */
    public function getTargetMenu(): Collection
    {
        return $this->targetMenu;
    }

    /**
     * @param Menu $targetMenu
     * @return $this
     */
    public function addTargetMenu(Menu $targetMenu): self
    {
        if (!$this->targetMenu->contains($targetMenu)) {
            $this->targetMenu[] = $targetMenu;
        }
        return $this;
    }

    /**
     * @param Menu $targetMenu
     * @return $this
     */
    public function removeTargetMenu(Menu $targetMenu): self
    {
        if ($this->targetMenu->contains($targetMenu)) {
            $this->targetMenu->removeElement($targetMenu);
        }
        return $this;
    }
}
