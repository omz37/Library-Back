<?php

namespace App\Entity;

use App\Repository\RentRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Classe Rent
 * @Serializer\ExclusionPolicy("all")
 */
#[ORM\Entity(repositoryClass: RentRepository::class)]
class Rent
{
    /**
     * @var int|null
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    #[ORM\Column]
    private ?string $bookID = null;

    /**
     * @var string|null
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    #[ORM\Column(length: 50)]
    private ?string $status = null;

    /**
     * @var User|null
     */
    #[ORM\ManyToOne(inversedBy: 'rents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $rentUser = null;

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
    public function getBookID(): ?string
    {
        return $this->bookID;
    }

    /**
     * @param string $bookID
     * @return $this
     */
    public function setBookID(string $bookID): self
    {
        $this->bookID = $bookID;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getRentUser(): ?User
    {
        return $this->rentUser;
    }

    /**
     * @param User|null $rentUser
     * @return $this
     */
    public function setRentUser(?User $rentUser): self
    {
        $this->rentUser = $rentUser;

        return $this;
    }
}
