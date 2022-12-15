<?php

namespace Model\Entitys;

class UserModel
{
    public int $id;
    public string $usename;
    public string $eMail;
    public bool $isAdmin = false;
    public bool $isModerator = false;

    public function __construct($id, $username, $eMail, $isAdmin, $isModerator)
    {
        $this->id = $id;
        $this->usename = $username;
        $this->eMail = $eMail;
        $this->isAdmin = $isAdmin;
        $this->isModerator = $isModerator;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsename(): string
    {
        return $this->usename;
    }

    /**
     * @param string $usename
     */
    public function setUsename(string $usename): void
    {
        $this->usename = $usename;
    }

    /**
     * @return string
     */
    public function getEMail(): string
    {
        return $this->eMail;
    }

    /**
     * @param string $eMail
     */
    public function setEMail(string $eMail): void
    {
        $this->eMail = $eMail;
    }

    /**
     * @return bool
     */
    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return bool
     */
    public function getIsModerator(): bool
    {
        return $this->isModerator;
    }

    /**
     * @param bool $isModerator
     */
    public function setIsModerator(bool $isModerator): void
    {
        $this->isModerator = $isModerator;
    }


}

