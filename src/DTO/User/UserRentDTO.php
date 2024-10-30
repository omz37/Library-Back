<?php

namespace App\DTO\User;

use App\DTO\Books\BookDTO;
use App\Entity\Rent;
use JMS\Serializer\Annotation as Serializer;

/**
 * Classe UserREntDTO
 * permet de standardiser l'objet contenant les emprunts d'un utilisateur
 * @Serializer\ExclusionPolicy("all")
 */
class UserRentDTO
{
    /**
     * @var Rent
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    protected Rent $rent;

    /**
     * @var BookDTO
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    protected BookDTO $bookDTO;

    /**
     * @param Rent $rent
     * @param BookDTO $bookDTO
     */
    public function __construct(Rent $rent, BookDTO $bookDTO)
    {
        $this->rent = $rent;
        $this->bookDTO = $bookDTO;
    }

    /**
     * @return Rent
     */
    public function getRent(): Rent
    {
        return $this->rent;
    }

    /**
     * @param Rent $rent
     * @return void
     */
    public function setRent(Rent $rent): void
    {
        $this->rent = $rent;
    }

    /**
     * @return BookDTO
     */
    public function getBookDTO(): BookDTO
    {
        return $this->bookDTO;
    }

    /**
     * @param BookDTO $bookDTO
     * @return void
     */
    public function setBookDTO(BookDTO $bookDTO): void
    {
        $this->bookDTO = $bookDTO;
    }
}