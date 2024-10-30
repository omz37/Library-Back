<?php

namespace App\DTO\Books;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class BookDTO
 * Permet de standardiser l'objet livre.
 *  @Serializer\ExclusionPolicy("all")
 */
class BookDTO
{
    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    protected string $id;

    /**
     * @var BookCategoryDTO
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    protected BookCategoryDTO $category;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    protected string $title;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    protected string $author;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    protected string $summary;

    /**
     * @var array
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    protected array $image;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    protected string $publishDate;

    /**
     * @var bool
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"rental"})
     */
    protected bool $isRented;

    /**
     * @param string $id
     * @param BookCategoryDTO $category
     * @param string $title
     * @param string $author
     * @param string $summary
     * @param array $image
     * @param string $publishDate
     * @param bool $isRented
     */
    public function __construct(string $id, BookCategoryDTO $category, string $title, string $author, string $summary, array $image, string $publishDate, bool $isRented)
    {
        $this->id = $id;
        $this->category = $category;
        $this->title = $title;
        $this->author = $author;
        $this->summary = $summary;
        $this->image = $image;
        $this->publishDate = $publishDate;
        $this->isRented = $isRented;
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
     * @return BookCategoryDTO
     */
    public  function getCategory(): BookCategoryDTO
    {
        return $this->category;
    }

    /**
     * @param BookCategoryDTO $category
     * @return void
     */
    public  function setCategory(BookCategoryDTO $category):void
    {
        $this->category = $category;
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
     * @return string
     */
    public  function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return void
     */
    public  function setAuthor(string $author):void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public  function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     * @return void
     */
    public  function setSummary(string $summary):void
    {
        $this->summary = $summary;
    }

    /**
     * @return array
     */
    public  function getImage(): array
    {
        return $this->image;
    }

    /**
     * @param array $image
     * @return void
     */
    public  function setImage(array $image):void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public  function getPublishDate(): string
    {
        return $this->publishDate;
    }

    /**
     * @param string $publishDate
     * @return void
     */
    public  function setPublishDate(string $publishDate):void
    {
        $this->publishDate = $publishDate;
    }

    /**
     * @return bool
     */
    public  function isRented(): bool
    {
        return $this->isRented;
    }

    /**
     * @param bool $isRented
     * @return void
     */
    public  function setIsRented(bool $isRented):void
    {
        $this->isRented = $isRented;
    }

}