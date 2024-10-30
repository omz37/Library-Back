<?php

namespace App\Services;

use App\Constants\ErrorCodeConstants;
use App\Constants\ErrorMessageConstants;
use App\Constants\RentConstants;
use App\DTO\Errors\RestException;
use App\DTO\User\CreateRentDTO;
use App\Entity\Rent;
use App\Entity\User;
use App\Repository\RentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Classe RentService
 *
 */
class RentService
{
    /**
     * @var RentRepository
     */
    private RentRepository $rentRepository;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param RentRepository $rentRepository
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     */
    public function __construct(RentRepository $rentRepository, EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->rentRepository = $rentRepository;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }


    /**
     * Fonction qui permet d'emprunter un livre
     * @param CreateRentDTO $rentDTO
     * @param User|null $user
     * @return void
     * @throws RestException
     */
    public function rentBook(CreateRentDTO $rentDTO, ?User $user = null): void
    {
        if ($this->rentRepository->findOneBy(['bookID' => $rentDTO->getBookID(), 'status' => RentConstants::STATUS_RENT_RENTED])) {
            throw new RestException(Response::HTTP_BAD_REQUEST, ErrorCodeConstants::ERR_BAD_REQUEST, ErrorMessageConstants::ERR_UNAVAILABLE_BOOK);
        }
        if (!$user) {
            $user = $this->userRepository->find($rentDTO->getUserID());
        }
        $rental = new Rent();
        $rental->setBookID($rentDTO->getBookID());
        $rental->setRentUser($user);
        $rental->setStatus(RentConstants::STATUS_RENT_RENTED);
        $user->addRent($rental);
        $this->entityManager->persist($rental);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}