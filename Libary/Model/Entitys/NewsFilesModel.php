<?php

namespace Model\Entitys;

class NewsFilesModel
{
    private string $id;
    private string $filename;
    private string $data;
    private string $newsId;

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
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getNewsId(): string
    {
        return $this->newsId;
    }

    /**
     * @param string $newsId
     */
    public function setNewsId(string $newsId): void
    {
        $this->newsId = $newsId;
    }
}