<?php

namespace App\DTO\User;

/**
 * Classe UserDTO
 * permet de standardiser l'objet de profil utilisateur
 */
class UserDTO
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $familyName;

    /**
     * @var string
     */
    protected string $email;

    /**
     * @param int $id
     * @param string $name
     * @param string $familyName
     * @param string $email
     */
    public function __construct(int $id, string $name, string $familyName, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->familyName = $familyName;
        $this->email = $email;
    }

    /**
     * @return int
     */
    public  function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return void
     */
    public  function setId(int $id):void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public  function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public  function setName(string $name):void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public  function getFamilyName(): string
    {
        return $this->familyName;
    }

    /**
     * @param string $familyName
     * @return void
     */
    public  function setFamilyName(string $familyName):void
    {
        $this->familyName = $familyName;
    }

    /**
     * @return string
     */
    public  function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return void
     */
    public  function setEmail(string $email):void
    {
        $this->email = $email;
    }
}