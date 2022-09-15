<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function uploadID(UploadedFile $file, $fileDirectory, $name)
    {
        $safeFilename = $this->slugger->slug($name);
        $fileName = $safeFilename. '-' .uniqid() . '.' .$file->guessExtension();

        try {
            $file->move($fileDirectory, $fileName);
        } catch (FileException $e) {
            echo 'erreur upload file';
        }

        return $fileName;
    }

    public function upload(UploadedFile $file, $fileDirectory, $name)
    {
        $safeFilename = $this->slugger->slug($name);
        $fileName = $safeFilename. '.' .$file->guessExtension();

        try {
            $file->move($fileDirectory, $fileName);
        } catch (FileException $e) {
            echo 'erreur upload file';
        }

        return $fileName;
    }
}