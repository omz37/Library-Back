<?php

namespace App\DTO\Edito;

/**
 * Classe RulesDTO
 * qui permet de standardiser le règlement intérieur
 */
class RulesDTO
{
    /**
     * @var string
     */
    protected string $id;

    /**
     * @var string
     */
    protected string $rulesTitle;

    /**
     * @var string
     */
    protected string $rulesSubtitle;

    /**
     * @var array<string>
     */
    protected array $rulesArticles;

    /**
     * @param string $id
     * @param string $rulesTitle
     * @param string $rulesSubtitle
     * @param string[] $rulesArticles
     */
    public function __construct(string $id, string $rulesTitle, string $rulesSubtitle, array $rulesArticles)
    {
        $this->id = $id;
        $this->rulesTitle = $rulesTitle;
        $this->rulesSubtitle = $rulesSubtitle;
        $this->rulesArticles = $rulesArticles;
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
    public  function getRulesTitle(): string
    {
        return $this->rulesTitle;
    }

    /**
     * @param string $rulesTitle
     * @return void
     */
    public  function setRulesTitle(string $rulesTitle):void
    {
        $this->rulesTitle = $rulesTitle;
    }

    /**
     * @return string
     */
    public  function getRulesSubtitle(): string
    {
        return $this->rulesSubtitle;
    }

    /**
     * @param string $rulesSubtitle
     * @return void
     */
    public  function setRulesSubtitle(string $rulesSubtitle):void
    {
        $this->rulesSubtitle = $rulesSubtitle;
    }

    /**
     * @return string[]
     */
    public  function getRulesArticles(): array
    {
        return $this->rulesArticles;
    }

    /**
     * @param array $rulesArticles
     * @return void
     */
    public  function setRulesArticles(array $rulesArticles):void
    {
        $this->rulesArticles = $rulesArticles;
    }



}