<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocialRepository")
 */
class Social
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
     * @ORM\Column(type="string", length=20)
     */
    private $shortcode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SocialLink", mappedBy="type")
     */
    private $socialLinks;

    /**
     * Social constructor.
     */
    public function __construct()
    {
        $this->socialLinks = new ArrayCollection();
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
    public function getShortcode(): ?string
    {
        return $this->shortcode;
    }

    /**
     * @param string $shortcode
     * @return $this
     */
    public function setShortcode(string $shortcode): self
    {
        $this->shortcode = $shortcode;
        return $this;
    }

    /**
     * @return Collection|SocialLink[]
     */
    public function getSocialLinks(): Collection
    {
        return $this->socialLinks;
    }

    /**
     * @param SocialLink $socialLink
     * @return $this
     */
    public function addSocialLink(SocialLink $socialLink): self
    {
        if (!$this->socialLinks->contains($socialLink)) {
            $this->socialLinks[] = $socialLink;
            $socialLink->setType($this);
        }
        return $this;
    }

    /**
     * @param SocialLink $socialLink
     * @return $this
     */
    public function removeSocialLink(SocialLink $socialLink): self
    {
        if ($this->socialLinks->contains($socialLink)) {
            $this->socialLinks->removeElement($socialLink);
            // set the owning side to null (unless already changed)
            if ($socialLink->getType() === $this) {
                $socialLink->setType(null);
            }
        }
        return $this;
    }
}
