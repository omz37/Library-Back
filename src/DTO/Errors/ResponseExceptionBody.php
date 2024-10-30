<?php

namespace App\DTO\Errors;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ResponseExceptionBody
 * Permet de standardiser l'objet de réponse renvoyé par les APIs.
 *
 * @Serializer\ExclusionPolicy("all")
 */
class ResponseExceptionBody
{
    /**
     * CODE HTTP.
     * @var string
     * @Serializer\Expose()
     */
    protected string $code;

    /**
     * Le code d'erreur rencontré si une erreur est rencontrée | optionnel.
     *  @var mixed | string
     * @Serializer\Expose()
     */
    protected ?string $errorCode = null;

    /**
     * Message de retour / d'erreurs ou d'exceptions.
     *  @var string
     * @Serializer\Expose()
     */
    protected string $message;

    /**
     * Description plus détaillée de l'erreur si une erreur est rencontrée | optionnel.
     *  @var string | mixed
     * @Serializer\Expose()
     */
    protected ?string $description = null;

    /**
     * Objet retourné si besoin ex. retourner l'objet USER après sa création, ...
     *
     * @var mixed|null
     *
     * @Serializer\Expose()
     */
    protected mixed $data = null;

    /**
     * Liste d'erreurs si une erreur est rencontrée | optionnel.
     *
     * @Serializer\Type("array")
     *  @var mixed
     *
     * @Serializer\Expose()
     */
    protected mixed $errors = null;

    /**
     * @param string $code
     * @param string $message
     */
    public function __construct(string $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return void
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * @param string|null $errorCode
     * @return void
     */
    public function setErrorCode(?string $errorCode): void
    {
        $this->errorCode = $errorCode;
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

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return void
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return void
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getErrors(): mixed
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     * @return void
     */
    public function setErrors(mixed $errors): void
    {
        $this->errors = $errors;
    }
}
