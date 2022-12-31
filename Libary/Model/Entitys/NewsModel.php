<?php

namespace Model\Entitys;

class NewsModel
{
    private string $id;
    private string $date = "";
    private string $headline;
    private string $description;
    private string $thumbnailName = "";
    private string $thumbnailData = "";
    private array $documents = [];
    private array $thumbnailUploadArray = [];

    /**
     * @param string $headline
     * @param string $description
     */
    public function __construct(string $headline, string $description)
    {
        $this->headline = $headline;
        $this->description = $description;
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
    public function getDate(): string
    {
        return $this->date;
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
    public function getHeadline(): string
    {
        return $this->headline;
    }

    /**
     * @param string $headline
     */
    public function setHeadline(string $headline): void
    {
        $this->headline = $headline;
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
     * @return string
     */
    public function getThumbnailName(): string
    {
        return $this->thumbnailName;
    }

    /**
     * @param string $thumbnailName
     */
    public function setThumbnailName(string $thumbnailName): void
    {
        $this->thumbnailName = $thumbnailName;
    }

    /**
     * @return string
     */
    public function getThumbnailData(): string
    {
        return $this->thumbnailData;
    }

    /**
     * @param string $thumbnailData
     */
    public function setThumbnailData(string $thumbnailData): void
    {
        $this->thumbnailData = $thumbnailData;
    }

    /**
     * @return array
     */
    public function getThumbnailUploadArray(): array
    {
        return $this->thumbnailUploadArray;
    }

    /**
     * @param array $thumbnailUploadArray
     */
    public function setThumbnailUploadArray(array $thumbnailUploadArray): void
    {
        $this->thumbnailUploadArray = $thumbnailUploadArray;
    }
}