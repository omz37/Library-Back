<?php

namespace App\Services;

use App\Constants\ErrorCodeConstants;
use App\Constants\ErrorMessageConstants;
use App\DTO\Books\CategoryListDTO;
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
 * Classe CategoryService
 * permet de créer la bonne requête puis de standardiser la réponse dans CategoryListDTO
 */
class CategoryService
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
     * Fonction qui permet de créer la bonne requête puis de standardiser la réponse dans CategoryListDTO
     * @param string $docType
     * @return CategoryListDTO|Response|RestException
     * @throws ClientExceptionInterface
     * @throws RestException
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function CategoryListDTOMaker(string $docType): CategoryListDTO|Response|RestException
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->prismicURL,
                ['query' => [
                    'ref' => $this->prismicRef,
                    'q' => PrismicURLMaker::PrismicQueryMaker(null, $docType)
                ]]
            );

            $content = $response->toArray();
            return new CategoryListDTO($content['total_results_size'], $content['results']);
        } catch (ClientException $clientException) {
            throw new RestException(Response::HTTP_BAD_REQUEST, ErrorCodeConstants::ERR_BAD_REQUEST, ErrorMessageConstants::ERR_BAD_REQUEST);
        }
    }
}