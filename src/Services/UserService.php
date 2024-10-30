<?php

namespace App\Services;

use App\Constants\ErrorCodeConstants;
use App\Constants\ErrorMessageConstants;
use App\Constants\UserConstants;
use App\DTO\Books\SearchBookQuery;
use App\DTO\Errors\RestException;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\EditUserDTO;
use App\DTO\User\UserListDTO;
use App\DTO\User\UserRentDTO;
use App\DTO\User\UserRentListDTO;
use App\Entity\User;
use App\Repository\RentRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

/**
 * Classe UserService
 * permet de hasher le mdp de l'utilisateur puis d'ajouter une entrée dans la BDD avec les infos reçues
 */
class UserService
{
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var RentRepository
     */
    private RentRepository $rentRepository;

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository, RentRepository $rentRepository)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->rentRepository = $rentRepository;
    }

    /**
     * @param CreateUserDTO $userDTO
     * @return void
     * Fonction qui permet de hasher le mdp de l'utilisateur puis d'ajouter une entrée dans la BDD avec les infos reçues
     * @throws RestException
     */
    public function createUser(CreateUserDTO $userDTO): void
    {
        try {
            $user = new User();
            $user->setName($userDTO->getName());
            $user->setFamilyName($userDTO->getFamilyName());
            $user->setEmail($userDTO->getEmail());
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $userDTO->getPassword()
            );
            $user->setPassword($hashedPassword);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $exception) {
            throw new RestException(Response::HTTP_BAD_REQUEST, ErrorCodeConstants::ERR_EMAIL_NOT_UNIQUE, ErrorMessageConstants::ERR_EMAIL_NOT_UNIQUE);
        }
    }

    /**
     * Fonction qui permet de modifier les infos d'un utilisateur
     * @param EditUserDTO $userDTO
     * @param User $user
     * @return void
     * @throws RestException
     */
    public function editUser(EditUserDTO $userDTO, User $user) : void
    {
        /**
         * check si l'email est disponible et si il n'as pas changé
         */
        if ($this->userRepository->findOneBy(['email' => $userDTO->getEmail()]) && $user->getEmail() !== $userDTO->getEmail()) {
            throw new RestException(Response::HTTP_BAD_REQUEST, ErrorCodeConstants::ERR_EMAIL_NOT_UNIQUE, ErrorMessageConstants::ERR_EMAIL_NOT_UNIQUE);
        }
        /**
         * interdit la transformation d'un user en admin
         */
        if (in_array(UserConstants::ROLE_ADMIN, $userDTO->getRoles())) {
            throw new RestException(Response::HTTP_FORBIDDEN, ErrorCodeConstants::ERR_FORBIDDEN, ErrorMessageConstants::ERR_FORBIDDEN);
        }
        $user->setName($userDTO->getName());
        $user->setFamilyName($userDTO->getFamilyName());
        $user->setEmail($userDTO->getEmail());
        $user->setRoles($userDTO->getRoles());
        $this->entityManager->flush();
    }

    /**
     * @param int $id
     * @return User
     * Fonction qui renvoie le profil demandé grâce a un ID
     * @throws RestException
     */
    public function getUserByID(int $id): User
    {
        $userEntity = $this->userRepository->find($id);
        if ($userEntity == null) {
            throw new RestException(Response::HTTP_NOT_FOUND, ErrorCodeConstants::ERR_NOT_FOUND, ErrorMessageConstants::ERR_NOT_FOUND);
        }
        return $userEntity;
    }

    /**
     * @param string|null $name
     * @param string|null $familyName
     * @param string|null $email
     * @return UserListDTO
     * @throws Throwable
     */
    public function getUsersByFilter(?string $name, ?string $familyName, ?string $email): UserListDTO
    {
        try {
            $criteria = [];
            switch (true) {
                case ($name && $name !== ''):
                    $criteria['name'] = $name;
                    break;
                case ($familyName && $familyName !== ''):
                    $criteria['familyName'] = $familyName;
                    break;
                case ($email && $email !== ''):
                    $criteria['email'] = $email;
                    break;
                default:
                    $criteria = [];
            }
            $users = $this->userRepository->findBy($criteria);

            return new UserListDTO($users);

        } catch (Throwable $restException) {
            throw $restException;
        }
    }

    /**
     * Fonction qui permet de récupérer les emprunts d'un utilisateur
     * @param User $user
     * @param BookService $service
     * @return UserRentListDTO
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws RestException
     * @throws ServerExceptionInterface
     * @throws Throwable
     * @throws TransportExceptionInterface
     */
    public function getUserRents(User $user, BookService $service): UserRentListDTO
    {
        $rents =  [];
        foreach ($user->getRents()->toArray() as $rent) {
            $query = new SearchBookQuery('id', $rent->getBookID());
            $bookDTO = $service->BookListDTOMaker('books', $query, $this->rentRepository);
            $rents[] = new UserRentDTO($rent, $bookDTO->getResults()[0]);
        }
        return new UserRentListDTO($rents);
    }
}
