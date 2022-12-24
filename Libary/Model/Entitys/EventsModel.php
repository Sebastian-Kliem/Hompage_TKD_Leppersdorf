<?php

namespace Model\Entitys;

class EventsModel
{
    private string $date;
    private string $name;
    private string $description = '';
    private array $documents;
    private string $eventYear;
    private string $eventMonth;
    private string $id;

    public function __construct($date, $name)
    {

        $this->date = $date;
        $this->name = $name;

        $dateTime = new \DateTime($this->date);

        $this->eventYear = $dateTime->format('Y');
        $this->eventMonth = $dateTime->format('m');

    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return array
     */
    public function getDocuments(): array
    {
        return $this->documents;
    }

    /**
     * @param array $documents
     */
    public function setDocuments(array $documents): void
    {
        $this->documents = $documents;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getEventYear(): string
    {
        return $this->eventYear;
    }

    /**
     * @param string $eventYear
     */
    public function setEventYear(string $eventYear): void
    {
        $this->eventYear = $eventYear;
    }

    /**
     * @return string
     */
    public function getEventMonth(): string
    {
        return $this->eventMonth;
    }

    /**
     * @param string $eventMonth
     */
    public function setEventMonth(string $eventMonth): void
    {
        $this->eventMonth = $eventMonth;
    }
}
