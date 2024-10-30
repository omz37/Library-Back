<?php

namespace App\EventListener;

use App\DTO\Errors\ResponseExceptionBody;
use App\Kernel;
use App\Normalizer\ExceptionNormalizer;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Classe ApiExceptionListener
 * Permet de trouver le bon service pour retourner l'objet d'erreur normalisé.
 */
class ApiExceptionListener implements EventSubscriberInterface
{
    /** @var SerializerInterface Le serializer à utiliser pour serializer le retour */
    private SerializerInterface $serializer;

    /** @var NormalizerInterface[] La liste des normalizers à utiliser pour les exceptions */
    private array $normalizers;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var Kernel
     */
    private Kernel $kernel;

    /**
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     * @param ExceptionNormalizer $httpExceptionNormalizer
     * @param Kernel $kernel
     */
    public function __construct(SerializerInterface $serializer, LoggerInterface $logger, ExceptionNormalizer $httpExceptionNormalizer, Kernel $kernel)
    {
        $this->serializer = $serializer;
        $this->logger = $logger;
        $this->normalizers[] = $httpExceptionNormalizer;
        $this->kernel = $kernel;
    }

    /**
     * @return array[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [['processException', 255]],
        ];
    }


    /**
     * @param ExceptionEvent $event
     * @return void
     *  Permet de trouver parmi tous les normalizers le service qui
     *  sera en charge de retourner l'objet normalisé comme il faut.
     */
    public function processException(ExceptionEvent $event): void
    {
        if ($this->checkIsApiRoute($event)) {
            $this->logger->error($event->getThrowable());

            $result = null;

            foreach ($this->normalizers as $normalizer) {
                if ($normalizer->supports($event->getThrowable())) {
                    $result = $normalizer->normalize($event->getThrowable());
                    break;
                }
            }

            if (is_null($result)) {
                $result = new ResponseExceptionBody(Response::HTTP_INTERNAL_SERVER_ERROR, $event->getThrowable()->getMessage());
                if ($this->kernel->isDebug()) {
                    $result->setDescription($event->getThrowable()->getTraceAsString());
                }
            }

            $body = $this->serializer->serialize($result, 'json');
            $event->setResponse(new Response($body, $result->getCode(), ['content-type' => 'application/json']));
        }
    }


    /**
     * @param ExceptionEvent $event
     * @return bool
     *  Permet de savoir si il s'agit d'une route d'api pour laquelle il faut gérer les remontées d'exceptions.
     */
    private function checkIsApiRoute(ExceptionEvent $event): bool
    {
        if (str_starts_with($event->getRequest()->getPathInfo(), '/api/swagger')) {
            return false;
        }

        return str_starts_with($event->getRequest()->getPathInfo(), '/api/');
    }
}
