<?php

namespace App\DTO\User;

use App\Constants\ErrorMessageConstants;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Classe CreateRentDTO
 * permet de standardiser le body de requête ppur louer un livre
 */
class CreateRentDTO
{
    /**
     * @var int
     */
    #[NotBlank([])]
    #[Length(['min' => 2, 'max' => 255, 'minMessage' => ErrorMessageConstants::ERR_NAME_TOO_SHORT,
        'maxMessage' => ErrorMessageConstants::ERR_NAME_TOO_LONG])]
    protected int $userID;

    /**
     * @var string
     */
    #[NotBlank([])]
    #[Length(['min' => 2, 'max' => 255, 'minMessage' => ErrorMessageConstants::ERR_NAME_TOO_SHORT,
        'maxMessage' => ErrorMessageConstants::ERR_NAME_TOO_LONG])]
    protected string $bookID;

    /**
     * @param int $userID
     * @param string $bookID
     */
    public function __construct(int $userID, string $bookID)
    {
        $this->userID = $userID;
        $this->bookID = $bookID;
    }

    /**
     * @return int
     */
    public  function getUserID(): int
    {
        return $this->userID;
    }

    /**
     * @param int $userID
     * @return void
     */
    public  function setUserID(int $userID):void
    {
        $this->userID = $userID;
    }

    /**
     * @return string
     */
    public  function getBookID(): string
    {
        return $this->bookID;
    }

    /**
     * @param string $bookID
     * @return void
     */
    public  function setBookID(string $bookID):void
    {
        $this->bookID = $bookID;
    }
}