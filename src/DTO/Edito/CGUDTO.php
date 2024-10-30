<?php

namespace App\DTO\Edito;

/**
 * Classe CGUDto
 * qui permet de standardiser les CGU
 */
class CGUDTO
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
     * @var array<string>
     */
    protected array $articles;

    /**
     * @param string $id
     * @param string $title
     * @param array<string> $articles
     */
    public function __construct(string $id, string $title, array $articles)
    {
        $this->id = $id;
        $this->title = $title;
        $this->articles = $articles;
    }

    /**
     * @return string
     */
    public  function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return void
     */
    public  function setId(string $id):void
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

    /**
     * @return array<string>
     */
    public  function getArticles(): array
    {
        return $this->articles;
    }

    /**
     * @param array<string> $articles
     * @return void
     */
    public  function setArticles(array $articles):void
    {
        $this->articles = $articles;
    }

}