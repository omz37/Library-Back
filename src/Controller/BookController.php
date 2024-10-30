<?php

namespace App\Controller;

use App\Constants\BookConstants;
use App\Constants\ErrorCodeConstants;
use App\Constants\ErrorMessageConstants;
use App\DTO\Books\BookListDTO;
use App\DTO\Books\SearchBookQuery;
use App\DTO\Errors\RestException;
use App\Repository\RentRepository;
use App\Services\BookService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Throwable;

#[Route('/api/books')]
/**
 * @OA\Tag(name="Books")
 *
 * Classe BookController qui permet de créer
 * les routes associées aux livres.
 */
class BookController extends AbstractController
{
    /**
     * @var BookService
     */
    private BookService $bookService;

    /**
     * @var RentRepository
     */
    private RentRepository $rentRepository;

    /**
     * @param BookService $bookService
     * @param RentRepository $rentRepository
     */
    public function __construct(BookService $bookService, RentRepository $rentRepository)
    {
        $this->bookService = $bookService;
        $this->rentRepository = $rentRepository;
    }


    #[Rest\Get('/', name: 'book_list')]
    /**
     * Route qui permet d'obtenir tous les livres ou retourner les livres à l'aide d'un filtre choisi.
     *
     * @OA\Response(
     *    response=200,
     *    @OA\JsonContent(ref=@Model(type=BookListDTO::class)),
     *    description="Tous les livres de la catégorie choisie"
     *  )
     *
     * @OA\Response(
     *    response=400,
     *    description="Mauvaise requête: URL ou ref non valide"
     *  )
     *
     * @OA\Parameter(
     *    parameter="filter",
     *    name="filter",
     *    description="The filter type and values",
     *    @OA\JsonContent(ref=@Model(type=SearchBookQuery::class)),
     *    in="query",
     *    required=false
     *  )
     *
     * @param string|null $type
     * @param string|null $value
     * @param string $page
     * @param string $pageSize
     * @return BookListDTO|RestException
     * @throws RestException
     * @QueryParam(name="type", requirements="[a-z]+", description="type of filter")
     * @QueryParam(name="value", description="value of filter")
     * @QueryParam(name="page", requirements="\d+", default="1", description="page")
     * @QueryParam(name="pageSize", requirements="\d+", default=10, description="pageSize", strict=true)
     */
    public function getBooksByFilterAction(?string $type, ?string $value, string $page, string $pageSize): BookListDTO|RestException
    {
        $query = new SearchBookQuery($type, $value, $page, $pageSize);
        try {
            return $this->bookService->BookListDTOMaker(BookConstants::TYPE_BOOKS, $query, $this->rentRepository);
        } catch (RestException $restException) {
            throw $restException;
        } catch (Throwable $throwable) {
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, ErrorCodeConstants::ERR_UNEXPECTED, ErrorMessageConstants::ERR_UNEXPECTED);
        }
    }
}