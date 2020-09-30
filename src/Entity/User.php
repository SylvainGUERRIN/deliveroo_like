<?php


namespace App\Entity;

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
