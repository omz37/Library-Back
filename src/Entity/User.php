<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\DBAL\Types\Types;

/**
 * Classe User
 * Permet de définir la Classe User comme une entité et spécifie sa classe de Repository
 *  @Serializer\ExclusionPolicy("all")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    /**
     * @var int|null
     * ID de l'user
     * @Serializer\Expose()
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     * Nom de l'user
     * @Serializer\Expose()
     */
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var string|null
     * Nom de famille de l'user
     * @Serializer\Expose()
     */
    #[ORM\Column(length: 50)]
    private ?string $familyName = null;

    /**
     * @var string|null
     * Email de l'user
     * @Serializer\Expose()
     */
    #[ORM\Column(length: 100, unique: true)]
    private ?string $email = null;

    /**
     * @var string|null
     * Mot de passe de l'user
     */
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    /**
     * @var string[]|null
     * Roles de l'utilisateur
     * @Serializer\Expose()
     */
    #[ORM\Column(type: Types::ARRAY)]
    private ?array $roles;

    /**
     * @var Collection
     * Emprunts de l'utilisateur
     */
    #[ORM\OneToMany(mappedBy: 'rentUser', targetEntity: Rent::class, orphanRemoval: true)]
    private Collection $rents;

    public function __construct()
    {
        $this->rents = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getID(): ?int
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
    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    /**
     * @param string $familyName
     * @return $this
     */
    public function setFamilyName(string $familyName): self
    {
        $this->familyName = $familyName;

        return $this;
    }

    /**
     * @return string|null
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
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Renvoie les rôles utilisateurs
     * @return string[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return void
     */
    public function setRoles(array $roles) : void
    {
        $this->roles = $roles;
    }

    /**
     * Reste a faire
     * @return void
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Renvoie l'identifiant utilisé pour se connecter
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @return Collection<int, Rent>
     */
    public function getRents(): Collection
    {
        return $this->rents;
    }

    public function addRent(Rent $rent): self
    {
        if (!$this->rents->contains($rent)) {
            $this->rents->add($rent);
            $rent->setRentUser($this);
        }

        return $this;
    }

    public function removeRent(Rent $rent): self
    {
        if ($this->rents->removeElement($rent)) {
            // set the owning side to null (unless already changed)
            if ($rent->getRentUser() === $this) {
                $rent->setRentUser(null);
            }
        }

        return $this;
    }
}
