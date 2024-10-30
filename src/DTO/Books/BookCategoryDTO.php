<?php

namespace App\DTO\Books;

/**
 * Classe BookCategoryDTO
 * qui permet de standardiser le filtre par catégorie
 */
class BookCategoryDTO
{
    /**
     * @var string
     */
    protected string $id;

    /**
     * @var string
     */
    protected string $title;

    /**
     * @param string $id
     * @param string $title
     */
    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * @return int
     */
    public  function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return void
     */
    public  function setId(int $id):void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public  function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return void
     */
    public  function setTitle(string $title):void
    {
        $this->title = $title;
    }
}