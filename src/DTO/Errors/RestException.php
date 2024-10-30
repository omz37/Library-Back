<?php

namespace App\DTO\Errors;

use Exception;

/**
 * Cette classe RestException
 * est un DTO pour toutes les exceptions possibles.
 */
final class RestException extends Exception
{
    /**
     * @var string|null
     * Cette var contient un code texte associée à l'erreur qui s'est produit
     */
    protected ?string $codeText = null;

    /**
     * @var mixed|null
     * Cette var contient un tableau qui se remplira si il y a une liste de plusieurs erreurs
     */
    protected array $data = [];

    /**
     * @var mixed|null
     *                 Cette var est de type mixed car peut contenir plusieurs types d'erreurs
     *                 mais aussi qu'il n'y ai pas de violationErrors et donc que la valeure soit nulle
     */
    protected mixed $violationErrors = null;

    /**
     * @param int $statusCode
     * @param string $codeText
     * @param string $errorMessage
     * @param mixed|null $violationErrors
     */
    public function __construct(int $statusCode, string $codeText, string $errorMessage, mixed $violationErrors = null)
    {
        parent::__construct($errorMessage, $statusCode);
        $this->codeText = $codeText;
        $this->violationErrors = $violationErrors;
    }

    /**
     * @return string
     */
    public function getCodeText(): string
    {
        return $this->codeText;
    }

    /**
     * @param string $code
     * @return void
     */
    public function setCodeText(string $code): void
    {
        $this->codeText = $code;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return void
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getViolationErrors(): mixed
    {
        return $this->violationErrors;
    }

    /**
     * @param mixed $violationErrors
     * @return void
     */
    public function setViolationErrors(mixed $violationErrors): void
    {
        $this->violationErrors = $violationErrors;
    }
}
