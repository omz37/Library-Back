<?php

namespace App\DTO\Edito;

/**
 * Classe ScheduleDTO
 * qui permet de standardiser les horaires
 */
class ScheduleDTO
{
    /**
     * @var string
     */
    protected string $id;

    /**
     * @var string
     */
    protected string $scheduleTitle;

    /**
     * @var array<string>
     */
    protected array $weekSchedule;

    /**
     * @param string $id
     * @param string $scheduleTitle
     * @param string[] $weekSchedule
     */
    public function __construct(string $id, string $scheduleTitle, array $weekSchedule)
    {
        $this->id = $id;
        $this->scheduleTitle = $scheduleTitle;
        $this->weekSchedule = $weekSchedule;
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
    public  function getScheduleTitle(): string
    {
        return $this->scheduleTitle;
    }

    /**
     * @param string $scheduleTitle
     * @return void
     */
    public  function setScheduleTitle(string $scheduleTitle):void
    {
        $this->scheduleTitle = $scheduleTitle;
    }

    /**
     * @return string[]
     */
    public  function getWeekSchedule(): array
    {
        return $this->weekSchedule;
    }

    /**
     * @param array $weekSchedule
     * @return void
     */
    public  function setWeekSchedule(array $weekSchedule):void
    {
        $this->weekSchedule = $weekSchedule;
    }
}