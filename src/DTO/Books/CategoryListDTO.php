<?php

namespace App\DTO\Books;

/**
 * Classe CategoryListDTO
 * Permet de standardiser l'objet qui contient une liste de catégories.
 */
class CategoryListDTO
{
    /**
     * @var int
     */
    protected int $results_size;

    /**
     * @var array<BookCategoryDTO>
     */
    protected array $results;

    /**
     * @param int $results_size
     * @param array $results
     */
    public function __construct(int $results_size, array $results)
    {
        $this->results_size = $results_size;
        $this->results = $this->categoryDTOListCreator($results);
    }

    /**
     * @param array $results
     * @return array<BookCategoryDTO>
     */
    private function categoryDTOListCreator(array $results): array
    {
        $formattedArray = $results;
        foreach ($formattedArray as &$result) {
            $result = new BookCategoryDTO($result['id'], $result['data']['title']);
        }
        return $formattedArray;
    }

    /**
     * @return array<BookCategoryDTO>
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
}