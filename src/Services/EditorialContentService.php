<?php

namespace App\Services;

use App\Constants\BookConstants;
use App\Constants\ErrorCodeConstants;
use App\Constants\ErrorMessageConstants;
use App\DTO\Edito\CGUDTO;
use App\DTO\Edito\IntroDTO;
use App\DTO\Edito\RulesDTO;
use App\DTO\Edito\ScheduleDTO;
use App\DTO\Errors\RestException;
use App\Utils\PrismicURLMaker;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Classe EditorialContentService
 * permet de créer la bonne requête puis de standardiser la réponse dans un DTO
 */
class EditorialContentService
{
    /**
     * @var string
     */
    private string $prismicRef;

    /**
     * @var string
     */
    private string $prismicURL;

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;

    /**
     * @param string $prismicRef
     * @param string $prismicURL
     * @param HttpClientInterface $client
     */
    public function __construct(string $prismicRef, string $prismicURL, HttpClientInterface $client)
    {
        $this->prismicRef = $prismicRef;
        $this->prismicURL = $prismicURL;
        $this->httpClient = $client;
    }

    /**
     * Fonction qui permet de créer la bonne requête puis de standardiser la réponse dans un DTO d'éditos
     * @param string $editorialType
     * @return CGUDTO|IntroDTO|RulesDTO|ScheduleDTO|RestException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws RestException
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function EditorialContentDTOMaker(string $editorialType): CGUDTO|IntroDTO|RulesDTO|ScheduleDTO|RestException
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->prismicURL,
                ['query' => [
                    'ref' => $this->prismicRef,
                    'q' => PrismicURLMaker::PrismicEditorialURLMaker($editorialType),
                ]]
            );

            $rawContent = $response->toArray();
            $content = $rawContent['results'][0];
            match ($editorialType) {
                BookConstants::TYPE_CGU => $dto = new CGUDTO($content['id'], $content['data']['cgutitle'], $content['data']['articles']),
                BookConstants::TYPE_INTRODUCTION => $dto = new IntroDTO($content['id'], $content['data']['introtitle'], $content['data']['introsubtitle'], $content['data']['introimage'], $content['data']['introtext']),
                BookConstants::TYPE_RULES => $dto = new RulesDTO($content['id'], $content['data']['ruletitle'], $content['data']['rulesubtitle'], $content['data']['rulearticles']),
                BookConstants::TYPE_SCHEDULE => $dto = new ScheduleDTO($content['id'], $content['data']['scheduletitle'], $content['data']['weekschedule'])
            };
            return $dto;
        } catch (ClientException $clientException) {
            throw new RestException(Response::HTTP_BAD_REQUEST, ErrorCodeConstants::ERR_BAD_REQUEST, ErrorMessageConstants::ERR_BAD_REQUEST);
        }
    }
}