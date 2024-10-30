<?php

namespace App\DTO\Books;

/**
 * Classe SearchBookQuery
 * qui permet de standardiser la requête de recherche de livres
 */
class SearchBookQuery
{
    /**
     * @var string
     */
    protected string $type;

    /**
     * @var string
     */
    protected string $value;

    /**
     * @var string
     */
    protected string $page;

    /**
     * @var string
     */
    protected string $pageSize;

    /**
     * @param string $type
     * @param string $value
     * @param string|null $page
     * @param string|null $pageSize
     */
    public function __construct(string $type, string $value, ?string $page = null, ?string $pageSize = null)
    {
        $this->type = $type;
        $this->value = $value;
        $page ? $this->page = $page : $this->page = "1";
        $pageSize ? $this->pageSize = $pageSize : $this->pageSize = "10";
    }

    /**
     * @return string
     */
    public  function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return void
     */
    public  function setType(string $type):void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public  function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return void
     */
    public  function setValue(string $value):void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public  function getCurrentPage(): string
    {
        return $this->page;
    }

    /**
     * @param string $currentPage
     * @return void
     */
    public  function setCurrentPage(string $currentPage):void
    {
        $this->page = $currentPage;
    }

    /**
     * @return string
     */
    public  function getPageSize(): string
    {
        return $this->pageSize;
    }

    /**
     * @param string $pageSize
     * @return void
     */
    public  function setPageSize(string $pageSize):void
    {
        $this->pageSize = $pageSize;
    }
}