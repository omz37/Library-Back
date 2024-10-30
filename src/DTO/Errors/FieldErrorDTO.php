<?php

namespace App\DTO\Errors;

/**
 * Class FieldErrorDTO
 * Permet de standardiser l'objet contenant les erreurs de Validation, le message et le path asssocié.
 */
final class FieldErrorDTO
{
    /**
     * @var string
     * contient le chemin vers la partie concernée par l'erreur
     */
    private string $propertyPath = '';

    /**
     * @var string
     * contient le message d'erreur
     */
    private string $message = '';

    /**
     * @param string $propertyPath
     * @param string $message
     */
    public function __construct(string $propertyPath, string $message)
    {
        $this->propertyPath = $propertyPath;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getPropertyPath(): string
    {
        return $this->propertyPath;
    }

    /**
     * @param string $propertyPath
     * @return void
     */
    public function setPropertyPath(string $propertyPath): void
    {
        $this->propertyPath = $propertyPath;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
