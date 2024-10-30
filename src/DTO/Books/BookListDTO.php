<?php

namespace App\DTO\Books;

use App\Constants\RentConstants;
use App\Repository\RentRepository;

/**
 * Class BookListDTO
 * Permet de standardiser l'objet qui contient une liste de livres.
 */
class BookListDTO
{
    /**
     * @var int
     */
    protected int $page;

    /**
     * @var int
     */
    protected int $results_per_page;

    /**
     * @var int
     */
    protected int $results_size;

    /**
     * @var int
     */
    protected int $total_pages;

    /**
     * @var array<BookDTO>
     */
    protected array $results;

    /**
     * @param int $page
     * @param int $results_per_page
     * @param int $results_size
     * @param int $total_pages
     * @param array $results
     * @param RentRepository $rentRepository
     */
    public function __construct(int $page, int $results_per_page, int $results_size, int $total_pages, array $results, RentRepository $rentRepository)
    {
        $this->page = $page;
        $this->results_per_page = $results_per_page;
        $this->results_size = $results_size;
        $this->total_pages = $total_pages;
        $this->results = $this->resultsDTOListCreator($results, $rentRepository);
    }

    /**
     * @param array $results
     * @param RentRepository $rentRepository
     * @return array<BookDTO>
     */
    private function resultsDTOListCreator(array $results, RentRepository $rentRepository): array
    {
        $formattedArray = $results;
        foreach ($formattedArray as &$result) {
            if ($result['type'] !== 'category') {
                $category = new BookCategoryDTO($result['data']['category']['uid'], $result['data']['category']['slug']);
            }
            $isRented = !is_null($rentRepository->findOneBy(['bookID' => $result['id'], 'status' => RentConstants::STATUS_RENT_RENTED]));
            $result = new BookDTO($result['id'], $category, $result['data']['title'], $result['data']['author'],
                                  $result['data']['summary'], $result['data']['image'], $result['data']['publish_date'], $isRented);

        }
        return $formattedArray;
    }

    /**
     * @return int
     */
    public  function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     * @return void
     */
    public  function setPage(int $page):void
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public  function getResultsPerPage(): int
    {
        return $this->results_per_page;
    }

    /**
     * @param int $results_per_page
     * @return void
     */
    public  function setResultsPerPage(int $results_per_page):void
    {
        $this->results_per_page = $results_per_page;
    }

    /**
     * @return array<BookDTO>
     */
    public  function getResults(): array
    {
        return $this->results;
    }

    /**
     * @param array $results
     * @return void
     */
    public  function setResults(array $results):void
    {
        $this->results = $results;
    }

    /**
     * @return int
     */
    public  function getResultsSize(): int
    {
        return $this->results_size;
    }

    /**
     * @param int $results_size
     * @return void
     */
    public  function setResultsSize(int $results_size):void
    {
        $this->results_size = $results_size;
    }

    /**
     * @return int
     */
    public  function getTotalPages(): int
    {
        return $this->total_pages;
    }

    /**
     * @param int $total_pages
     * @return void
     */
    public  function setTotalPages(int $total_pages):void
    {
        $this->total_pages = $total_pages;
    }


}