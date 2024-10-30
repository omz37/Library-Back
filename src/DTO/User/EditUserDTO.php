<?php

namespace App\DTO\User;

use App\Constants\ErrorMessageConstants;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class EditUserDTO
 * Permet de standardiser l'objet utilisateur ainsi que les validations associées.
 */
final class EditUserDTO
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
     * @var array<string>
     * @Type("array<string>")
     */
    #[NotBlank([])]
    private array $roles;

    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array<string> $roles
     * @return void
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

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
}
