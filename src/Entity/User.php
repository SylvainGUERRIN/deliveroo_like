<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min="8",
     *     minMessage="Votre mot de passe doit comporter au minimum 8 caractères"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="json")
     */
    private $role = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gender", inversedBy="users")
     */
    private $gender;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Address", inversedBy="users")
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="commentedBy")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DisLike", mappedBy="user")
     */
    private $disLikes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Like", mappedBy="user")
     */
    private $likes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="users")
     */
    private $image;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cart", mappedBy="consumer", cascade={"persist", "remove"})
     */
    private $cart;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="consumer")
     */
    private $orders;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Restaurant", cascade={"persist", "remove"})
     */
    private $restaurant;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Restaurant", mappedBy="owner", cascade={"persist", "remove"})
     */
    private $owners;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="managers")
     */
    private $managedRestaurant;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->disLikes = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->orders = new ArrayCollection();
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
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return array
     */
    public function getRole(): array
    {
        return $this->role;
    }

    /**
     * @param array $role
     * @return $this
     */
    public function setRole(array $role): self
    {
        $this->role = $role;
        return  $this;
    }

    /**
     * @return Gender|null
     */
    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    /**
     * @param Gender|null $gender
     * @return $this
     */
    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;
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
        }
        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setCommentedBy($this);
        }
        return $this;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getCommentedBy() === $this) {
                $comment->setCommentedBy(null);
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
            $disLike->setUser($this);
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
            if ($disLike->getUser() === $this) {
                $disLike->setUser(null);
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
            $like->setUser($this);
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
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }
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
     * @return Cart|null
     */
    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    /**
     * @param Cart|null $cart
     * @return $this
     */
    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;
        // set (or unset) the owning side of the relation if necessary
        $newConsumer = null === $cart ? null : $this;
        if ($cart->getConsumer() !== $newConsumer) {
            $cart->setConsumer($newConsumer);
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
            $order->setConsumer($this);
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
            // set the owning side to null (unless already changed)
            if ($order->getConsumer() === $this) {
                $order->setConsumer(null);
            }
        }
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

    /**
     * @return Restaurant|null
     */
    public function getOwners(): ?Restaurant
    {
        return $this->owners;
    }

    /**
     * @param Restaurant|null $owners
     * @return $this
     */
    public function setOwners(?Restaurant $owners): self
    {
        $this->owners = $owners;
        // set (or unset) the owning side of the relation if necessary
        $newOwner = null === $owners ? null : $this;
        if ($owners->getOwner() !== $newOwner) {
            $owners->setOwner($newOwner);
        }
        return $this;
    }

    /**
     * @return Restaurant|null
     */
    public function getManagedRestaurant(): ?Restaurant
    {
        return $this->managedRestaurant;
    }

    /**
     * @param Restaurant|null $managedRestaurant
     * @return $this
     */
    public function setManagedRestaurant(?Restaurant $managedRestaurant): self
    {
        $this->managedRestaurant = $managedRestaurant;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->firstName;
    }

    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->role;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return string
     */
    public function serialize():string
    {
        return serialize([$this->id, $this->firstName, $this->lastName, $this->email, $this->password]);
    }

    /**
     * @param $serialized
     */
    public function unserialize($serialized): void
    {
        [$this->id, $this->firstName, $this->lastName, $this->email, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }
}
