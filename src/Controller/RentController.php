<?php

namespace App\Controller;

use App\Constants\ErrorCodeConstants;
use App\Constants\ErrorMessageConstants;
use App\Constants\UserConstants;
use App\DTO\Errors\RestException;
use App\DTO\User\CreateRentDTO;
use App\Entity\Rent;
use App\Services\RentService;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

#[Route('/api/rents')]
/**
 *   @OA\Tag(name="Rental")
 *
 * Classe principale RentController qui permet de louer
 * des livres et d'rengister l'emprunt dans la BDD.
 */
class RentController extends AbstractController
{
    #[Route('/', name: 'create_rent', methods: 'POST')]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_RENT_ALLOWED")'))]
    /**
     *  Route qui permet de louer un livre dans la BDD
     *
     * @OA\Response(
     *     response=201,
     *     description="Emprunt réussi",
     *  )
     * @OA\Response(
     *     @OA\JsonContent(ref=@Model(type=RestException::class)),
     *     response=400,
     *     description="Formulaire invalide/non unique",
     *  )
     *  @OA\Response(
     *     @OA\JsonContent(ref=@Model(type=RestException::class)),
     *      response=500,
     *      description="Erreur inconnue",
     *   )
     * @OA\RequestBody(
     *     required=true,
     *     description="Body qui contient l'ID de l'utilisateur et du livre a emprunter",
     *     @OA\JsonContent(ref=@Model(type=CreateRentDTO::class))
     *  )
     *
     * @ParamConverter("rentDTO", converter="fos_rest.request_body")
     * @param RentService $service
     * @param CreateRentDTO $rentDTO
     * @param ConstraintViolationListInterface $validationErrors
     * @return Response
     * @throws RestException
     */
    public function rentAction(RentService $service, CreateRentDTO $rentDTO, ConstraintViolationListInterface $validationErrors): Response
    {
        try {
            if (count($validationErrors) > 0) {
                throw new RestException(Response::HTTP_BAD_REQUEST, ErrorCodeConstants::ERR_BAD_REQUEST, ErrorMessageConstants::ERR_BAD_REQUEST, $validationErrors);
            }
            $currentUser = $this->getUser();

            /**
             * vérifie que l'utilisateur a les droits appropriés
             */
            if (!in_array(UserConstants::ROLE_ADMIN, $currentUser->getRoles()) && $currentUser->getID() !== $rentDTO->getUserID()) {
                throw new RestException(Response::HTTP_FORBIDDEN, ErrorCodeConstants::ERR_FORBIDDEN, ErrorMessageConstants::ERR_FORBIDDEN);
            }

            $service->rentBook($rentDTO, $currentUser);
            return new Response(null, Response::HTTP_CREATED);
        } catch (RestException $restException) {
            throw $restException;
        } catch (Throwable $throwable) {
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, ErrorCodeConstants::ERR_UNEXPECTED, ErrorMessageConstants::ERR_UNEXPECTED);
        }
    }
}
