<?php

namespace App\Controller;

use App\Constants\ErrorCodeConstants;
use App\Constants\ErrorMessageConstants;
use App\Constants\UserConstants;
use App\DTO\Errors\RestException;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\EditUserDTO;
use App\DTO\User\UserListDTO;
use App\DTO\User\UserRentListDTO;
use App\Entity\User;
use App\Services\BookService;
use App\Services\UserService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Throwable;

#[Route('/api/users')]
/**
 *   @OA\Tag(name="User")
 *
 * Classe principale UserController qui permet de créer
 * les routes associées à l'utilisateur et à l'enregistrer' dans la BDD.
 */
class UserController extends AbstractController
{
    /**
     * @var BookService
     */
    private BookService $bookService;

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @param BookService $bookService
     * @param UserService $userService
     */
    public function __construct(BookService $bookService, UserService $userService)
    {
        $this->bookService = $bookService;
        $this->userService = $userService;
    }

    #[Route('/register', name: 'register', methods: 'POST')]
    /**
     *  Route qui permet d'enregistrer un utilisateur dans la BDD
     *
     * @OA\Response(
     *     response=201,
     *     description="Enregistrement réussi",
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
     *     description="Body qui contient les infos de l'utilisateur",
     *     @OA\JsonContent(ref=@Model(type=CreateUserDTO::class))
     *  )
     *
     * @ParamConverter("userDTO", converter="fos_rest.request_body")
     * @param CreateUserDTO $userDTO
     * @param ConstraintViolationListInterface $validationErrors
     * @return Response
     * @throws RestException
     */
    public function registerAction(CreateUserDTO $userDTO, ConstraintViolationListInterface $validationErrors): Response
    {
        if (count($validationErrors) > 0) {
            throw new RestException(Response::HTTP_BAD_REQUEST, 'form_info_error', 'Des erreurs sont survenues', $validationErrors);
        }
        try {
            $this->userService->createUser($userDTO);
        } catch (RestException $restException) {
            throw $restException;
        } catch (Throwable $throwable) {
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, ErrorCodeConstants::ERR_UNEXPECTED, ErrorMessageConstants::ERR_UNEXPECTED);
        }

        /**
         * Retour d'une réponse vide dans le cas ou il n'y a aucune erreur
         */
        return new Response(null, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'user_profile', methods: 'GET')]
    /**
     *  Route qui permet d'obtenir le profil de l'utilisateur lié a cet ID dans la BDD.
     *
     * @OA\Response(
     *     @OA\JsonContent(ref=@Model(type=User::class)),
     *     response=200,
     *     description="Données du profil utilisateur"
     *  )
     * @OA\Response(
     *     @OA\JsonContent(ref=@Model(type=RestException::class)),
     *     response=403,
     *     description="Non authorisé: n'as pas les droits"
     *  )
     *  @OA\Response(
     *      @OA\JsonContent(ref=@Model(type=RestException::class)),
     *      response=500,
     *      description="Erreur inconnue"
     *   )
     *
     * @throws RestException
     */
    public function getUserAction(int $id): User
    {
       try {
           $currentUser = $this->getUser();

           /**
            * vérifie que l'utilisateur a les droits appropriés
            */
           if (!in_array(UserConstants::ROLE_ADMIN, $currentUser->getRoles()) && $currentUser->getID() !== $id) {
               throw new RestException(Response::HTTP_FORBIDDEN, ErrorCodeConstants::ERR_FORBIDDEN, ErrorMessageConstants::ERR_FORBIDDEN);
           }
           return $this->userService->getUserByID($id);

       } catch (RestException $restException) {
           throw $restException;
       } catch (Throwable $throwable) {
           throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, ErrorCodeConstants::ERR_UNEXPECTED, ErrorMessageConstants::ERR_UNEXPECTED);
       }
    }

    #[Route('/', name: 'user_list', methods: 'GET')]
    #[IsGranted('ROLE_ADMIN', statusCode: 403)]
    /**
     *  Route qui permet d'obtenir la liste des profils utilisateur dans la BDD.
     *
     * @OA\Response(
     *     @OA\JsonContent(ref=@Model(type=User::class)),
     *     response=200,
     *     description="Données du profil utilisateur"
     *  )
     * @OA\Response(
     *      @OA\JsonContent(ref=@Model(type=RestException::class)),
     *      response=403,
     *      description="Non authorisé: n'as pas les droits"
     *  )
     * @OA\Response(
     *       @OA\JsonContent(ref=@Model(type=RestException::class)),
     *       response=500,
     *       description="Erreur inconnue"
     *  )
     *
     * @QueryParam(name="name", requirements="[a-z A-Z.-]+", description="nom utilisateur")
     * @QueryParam(name="familyName", requirements="[a-z A-Z.-]+", description="prénom utilisateur")
     * @QueryParam(name="email", requirements="[a-z A-Z.-@]+", description="email utilisateur")
     * @throws RestException
     */
    public function getUsersAction(?string $name, ?string $familyName, ?string $email): UserListDTO
    {
        try {
            $currentUser = $this->getUser();

            /**
             * vérifie que l'utilisateur a les droits appropriés
             */
            if (!in_array(UserConstants::ROLE_ADMIN, $currentUser->getRoles())) {
                throw new RestException(Response::HTTP_FORBIDDEN, ErrorCodeConstants::ERR_FORBIDDEN, ErrorMessageConstants::ERR_FORBIDDEN);
            }
            return $this->userService->getUsersByFilter($name, $familyName, $email);

        } catch (RestException $restException) {
            throw $restException;
        } catch (Throwable $throwable) {
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, ErrorCodeConstants::ERR_UNEXPECTED, ErrorMessageConstants::ERR_UNEXPECTED);
        }
    }

    #[Route('/{id}/rents', name: 'user_rent_list', methods: 'GET')]
    /**
     *  @Rest\View(serializerGroups={"rental"})
     *  Route qui permet d'obtenir les emprunts de l'utilisateur lié a cet ID dans la BDD.
     *
     * @OA\Response(
     *     @OA\JsonContent(ref=@Model(type=UserRentListDTO::class)),
     *     response=200,
     *     description="Emprunts faits par l'utilisateurr"
     *  )
     * @OA\Response(
     *     @OA\JsonContent(ref=@Model(type=RestException::class)),
     *     response=403,
     *     description="Non authorisé: n'as pas les droits"
     *  )
     *  @OA\Response(
     *      @OA\JsonContent(ref=@Model(type=RestException::class)),
     *      response=500,
     *      description="Erreur inconnue"
     *   )
     *
     * @throws RestException
     */
    public function getUserRents(int $id) : UserRentListDTO
    {
        try {
            $currentUser = $this->getUser();

            if ($currentUser->getID() !== $id && !in_array(UserConstants::ROLE_ADMIN, $currentUser->getRoles())) {
                throw new RestException(Response::HTTP_FORBIDDEN, ErrorCodeConstants::ERR_FORBIDDEN, ErrorMessageConstants::ERR_FORBIDDEN);
            }
            return $this->userService->getUserRents($currentUser->getID() === $id ? $currentUser : $this->userService->getUserByID($id), $this->bookService);

        } catch (RestException $restException) {
            throw $restException;
        } catch (Throwable $throwable) {
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, ErrorCodeConstants::ERR_UNEXPECTED, ErrorMessageConstants::ERR_UNEXPECTED);
        }
    }

    #[Route('/{id}', name: 'edit_user', methods: 'PUT')]
    /**
     *  Route qui permet de modifier un utilisateur dans la BDD
     *
     * @OA\Response(
     *     response=200,
     *     description="Modification réussie",
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
     *     description="Body qui contient les infos de l'utilisateur",
     *     @OA\JsonContent(ref=@Model(type=CreateUserDTO::class))
     *  )
     *
     * @ParamConverter("userDTO", converter="fos_rest.request_body")
     * @param EditUserDTO $userDTO
     * @param UserService $userService
     * @param ConstraintViolationListInterface $validationErrors
     * @param int $id
     * @return RestException|Response
     * @throws RestException
     */
    public function editUserAction(EditUserDTO $userDTO, UserService $userService, ConstraintViolationListInterface $validationErrors, int $id): RestException|Response
    {
        if (count($validationErrors) > 0) {
            throw new RestException(Response::HTTP_BAD_REQUEST, ErrorCodeConstants::ERR_BAD_REQUEST, ErrorMessageConstants::ERR_BAD_REQUEST, $validationErrors);
        }
        try {
            $currentUser = $this->getUser();

            if ($currentUser->getID() !== $id && !in_array(UserConstants::ROLE_ADMIN, $currentUser->getRoles())) {
                throw new RestException(Response::HTTP_FORBIDDEN, ErrorCodeConstants::ERR_FORBIDDEN, ErrorMessageConstants::ERR_FORBIDDEN);
            }
            $userService->editUser($userDTO, $currentUser->getID() === $id ? $currentUser : $userService->getUserByID($id));
        } catch (RestException $restException) {
            throw $restException;
        } catch (Throwable $throwable) {
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, ErrorCodeConstants::ERR_UNEXPECTED, ErrorMessageConstants::ERR_UNEXPECTED);
        }

        return new Response(null, Response::HTTP_OK);
    }
}