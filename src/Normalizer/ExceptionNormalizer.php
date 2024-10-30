<?php

namespace App\Normalizer;

use App\DTO\Errors\FieldErrorDTO;
use App\DTO\Errors\ResponseExceptionBody;
use App\DTO\Errors\RestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Validator\ConstraintViolationList;
use Throwable;

/**
 * classe ExceptionNormalizer
 * qui va normalizer toutes les exceptions et fournir les erreurs asssociées.
 */
class ExceptionNormalizer
{
    /**
     * @var string[]
     * contient des strings avec tous les types d'exceptions qui se sont produites
     */
    private array $exceptionTypes;

    public function __construct()
    {
        $this->exceptionTypes = [
            HttpException::class,
            AccessDeniedException::class,
            RestException::class,
            NotFoundHttpException::class,
            AuthenticationCredentialsNotFoundException::class];
    }

    /**
     * @return ResponseExceptionBody
     *                               Fonction qui permet de normalizer les exceptions
     */
    public function normalize(Throwable $exception): ResponseExceptionBody
    {
        $code = $this->getCodeForException($exception);
        $responseBody = new ResponseExceptionBody($code, $exception->getMessage());
        if ($exception instanceof RestException) {
            $responseBody->setErrorCode($exception->getCodeText());
            $responseBody->setErrors($this->normalizeValidationErrors($exception->getViolationErrors()));
        }

        return $responseBody;
    }

    /**
     * @param Throwable $exception
     * @return bool
     */
    public function supports(Throwable $exception): bool
    {
        return in_array(get_class($exception), $this->exceptionTypes);
    }

    /**
     * @return string
     *                Fonction qui trouve le code erreur associé a une exception
     */
    private function getCodeForException(Throwable $exception): string
    {
        switch (get_class($exception)) {
            case AuthenticationCredentialsNotFoundException::class:
                $code = Response::HTTP_FORBIDDEN;
                break;
            case AccessDeniedException::class:
                $code = Response::HTTP_UNAUTHORIZED;
                break;
            case RestException::class:
                $code = $exception->getCode();
                break;
            case NotFoundHttpException::class:
                $code = Response::HTTP_NOT_FOUND;
                break;
            default:
                $code = Response::HTTP_INTERNAL_SERVER_ERROR;
                break;
        }

        return $code;
    }

    /**
     * @return array|mixed
     * Fonction qui normalize les erreurs de validations reçues si elles sont des ConstraintViolationList
     */
    private function normalizeValidationErrors(mixed $validationErrors): mixed
    {
        $normalizedError = $validationErrors;
        if ($validationErrors instanceof ConstraintViolationList) {
            $normalizedError = [];
            foreach ($validationErrors as $error) {
                $normalizedError[] = new FieldErrorDTO($error->getPropertyPath(), $error->getMessage());
            }
        }

        return $normalizedError;
    }
}
