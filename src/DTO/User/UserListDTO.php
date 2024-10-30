<?php

namespace App\DTO\User;

use App\Entity\User;

/**
 * Classe UserListDTO
 * permet de standardiser la liste de UserProfileDTO
 */
class UserListDTO
{

    /**
     * @var int
     */
    protected int $total;

    /**
     * @var array<User>
     */
    protected array $users;

    /**
     * @param array<User> $users
     */
    public function __construct(array $users)
    {
        $this->total = count($users);
        $this->users = $users;
    }

    /**
     * @return int
     */
    public  function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     * @return void
     */
    public  function setTotal(int $total):void
    {
        $this->total = $total;
    }

    /**
     * @return array<User>
     */
    public  function getAllProfiles(): array
    {
        return $this->users;
    }

    /**
     * @param array<User> $users
     * @return void
     */
    public  function setAllProfiles(array $users):void
    {
        $this->users = $users;
    }
}