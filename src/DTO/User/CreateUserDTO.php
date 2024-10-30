<?php

namespace App\DTO\User;

use App\Constants\ErrorMessageConstants;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class CreateUserDTO
 * Permet de standardiser l'objet utilisateur ainsi que les validations associées.
 */
final class CreateUserDTO
{

    /**
     * @var string
     * contient le nom de l'utilisateur
     */
    #[NotBlank([])]
    #[Length(['min' => 2, 'max' => 50, 'minMessage' => ErrorMessageConstants::ERR_NAME_TOO_SHORT,
            'maxMessage' => ErrorMessageConstants::ERR_NAME_TOO_LONG])]
    private string $name;

    /**
     * @var string
     * contient le nom de famille de l'utilisateur
     */
    #[NotBlank([])]
    #[Length(['min' => 2, 'max' => 50, 'minMessage' => ErrorMessageConstants::ERR_NAME_TOO_SHORT,
            'maxMessage' => ErrorMessageConstants::ERR_NAME_TOO_LONG])]
    private string $familyName;

    /**
     * @var string
     * contient l'email de l'utilisateur
     */
    #[NotBlank([])]
    #[Email([])]
    private string $email;

    /**
     * @var string
     * contient le mot de passe de l'utilisateur
     */
    #[NotBlank([])]
    #[Length(['min' => 2, 'max' => 255, 'minMessage' => ErrorMessageConstants::ERR_PASS_TOO_SHORT,
        'maxMessage' => ErrorMessageConstants::ERR_PASS_TOO_LONG])]
    private string $password;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    /**
     * @param string $familyName
     * @return void
     */
    public function setFamilyName(string $familyName): void
    {
        $this->familyName = $familyName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
