<?php

namespace App\DTO\Edito;

/**
 * Classe IntroDTO
 * permet de standardiser l'objet contenant le contenu d'introduction
 */
class IntroDTO
{
    /**
     * @var string
     */
    protected string $id;

    /**
     * @var string
     */
    protected string $introTitle;

    /**
     * @var string
     */
    protected string $introSubtitle;

    /**
     * @var array
     */
    protected array $introImage;

    /**
     * @var string
     */
    protected string $introText;

    /**
     * @param string $id
     * @param string $introTitle
     * @param string $introSubtitle
     * @param array $introImage
     * @param string $introText
     */
    public function __construct(string $id, string $introTitle, string $introSubtitle, array $introImage, string $introText)
    {
        $this->id = $id;
        $this->introTitle = $introTitle;
        $this->introSubtitle = $introSubtitle;
        $this->introImage = $introImage;
        $this->introText = $introText;
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
    public  function getIntroTitle(): string
    {
        return $this->introTitle;
    }

    /**
     * @param string $introTitle
     * @return void
     */
    public  function setIntroTitle(string $introTitle):void
    {
        $this->introTitle = $introTitle;
    }

    /**
     * @return string
     */
    public  function getIntroSubtitle(): string
    {
        return $this->introSubtitle;
    }

    /**
     * @param string $introSubtitle
     * @return void
     */
    public  function setIntroSubtitle(string $introSubtitle):void
    {
        $this->introSubtitle = $introSubtitle;
    }

    /**
     * @return array
     */
    public  function getIntroImage(): array
    {
        return $this->introImage;
    }

    /**
     * @param array $introImage
     * @return void
     */
    public  function setIntroImage(array $introImage):void
    {
        $this->introImage = $introImage;
    }

    /**
     * @return string
     */
    public  function getIntroText(): string
    {
        return $this->introText;
    }

    /**
     * @param string $introText
     * @return void
     */
    public  function setIntroText(string $introText):void
    {
        $this->introText = $introText;
    }
}