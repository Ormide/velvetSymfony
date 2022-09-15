<?php
namespace App\Service;

class FileDirectory
{
    private $userDirectory;
    private $discDirectory;
    private $artistDirectory;

    public function __construct($userDirectory, $discDirectory, $artistDirectory)
    {
        $this->userDirectory = $userDirectory;
        $this->discDirectory = $discDirectory;
        $this->artistDirectory = $artistDirectory;
    }

    public function getUserDirectory()
    {
        return $this->userDirectory;
    }

    public function getDiscDirectory()
    {
        return $this->discDirectory;
    }

    public function getArtistDirectory()
    {
        return $this->artistDirectory;
    }

    public function getDirectory($fileTarget)
    {
        if ($fileTarget == 'user')
        {
            return $this->getUserDirectory();
        }
        else if ($fileTarget == 'disc')
        {
            return $this->getDiscDirectory();
        }
        else if ($fileTarget == 'artist')
        {
            return $this->getArtistDirectory();
        }
    }
}