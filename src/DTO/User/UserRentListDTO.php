<?php

namespace App\DTO\User;

use JMS\Serializer\Annotation as Serializer;

/**
 *  Classe UserRentlistDTO
 *  permet de standardiser l'objet contenant la liste des UserRentDTO
 * @Serializer\ExclusionPolicy("all")
 */
class UserRentListDTO
{
    /**
     * @var array<UserRentDTO>
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    protected array $rents;

    /**
     * @param array<UserRentDTO> $rents
     */
    public function __construct(array $rents)
    {
        $this->rents = $rents;
    }

    /**
     * @return array<UserRentDTO>
     */
    public function getRents(): array
    {
        return $this->rents;
    }

    /**
     * @param array<UserRentDTO> $rents
     * @return void
     */
    public function setRents(array $rents): void
    {
        $this->rents = $rents;
    }
}