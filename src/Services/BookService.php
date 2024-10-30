<?php

namespace App\Services;

use App\Constants\ErrorCodeConstants;
use App\Constants\ErrorMessageConstants;
use App\DTO\Books\BookListDTO;
use App\DTO\Books\SearchBookQuery;
use App\DTO\Errors\RestException;
use App\Repository\RentRepository;
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
 * Classe BookService
 * permet de créer la bonne requête puis de standardiser la réponse dans BookListDTO
 */
class BookService
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
     * Fonction qui permet de créer la bonne requête puis de standardiser la réponse dans BookListDTO
     * @param string $docType
     * @param SearchBookQuery|null $body
     * @param RentRepository $rentRepository
     * @return BookListDTO|Response|RestException
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws RestException
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function BookListDTOMaker(string $docType, ?SearchBookQuery $body = null, RentRepository $rentRepository): BookListDTO|Response|RestException
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->prismicURL,
                ['query' => [
                    'ref' => $this->prismicRef,
                    'q' => PrismicURLMaker::PrismicQueryMaker($body, $docType),
                    'pageSize' => $body->getPageSize(),
                    'page' => $body->getCurrentPage()
                ]]
            );

            $content = $response->toArray();
            return new BookListDTO($content['page'], $content['results_per_page'], $content['total_results_size'], $content['total_pages'], $content['results'], $rentRepository);
        } catch (ClientException $clientException) {
            throw new RestException(Response::HTTP_BAD_REQUEST, ErrorCodeConstants::ERR_BAD_REQUEST, ErrorMessageConstants::ERR_BAD_REQUEST);
        }
    }
}