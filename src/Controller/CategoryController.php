<?php

namespace App\Controller;

use App\Constants\BookConstants;
use App\Constants\ErrorCodeConstants;
use App\Constants\ErrorMessageConstants;
use App\DTO\Books\CategoryListDTO;
use App\DTO\Errors\RestException;
use App\Services\CategoryService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

#[Route('/api/categories')]
/**
 * @OA\Tag(name="Categories")
 *
 * Classe CategoryController qui permet de créer
 * la routes associée aux catégories.
 */
class CategoryController extends AbstractController
{
    /**
     * @var CategoryService
     */
    private CategoryService $categoryService;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    #[Rest\Get('/', name: 'category_list')]
    /**
     * Route qui permet d'obtenir toutes les catégories de livres.
     *
     * @OA\Response(
     *    response=200,
     *    @OA\JsonContent(ref=@Model(type=CategoryListDTO::class)),
     *    description="Toutes les catégories"
     *  )
     *
     * @OA\Response(
     *    response=400,
     *    description="Mauvaise requête: URL ou ref non valide"
     *  )
     *
     *
     * @return CategoryListDTO|RestException
     * @throws RestException
     */
    public function getCategoriesAction(): CategoryListDTO|RestException
    {
        try {
            return $this->categoryService->CategoryListDTOMaker(BookConstants::TYPE_CATEGORY);
        } catch (RestException $restException) {
            throw $restException;
        } catch (Throwable $throwable) {
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, ErrorCodeConstants::ERR_UNEXPECTED, ErrorMessageConstants::ERR_UNEXPECTED);
        }
    }
}