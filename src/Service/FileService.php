<?php

namespace App\Service;

use Symfony\Component\String\ByteString;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    private string $fileName;

    public function getFileName():string
    {
        return $this->fileName;
    }

    public function upload(string $directory, UploadedFile $file): void
    {
        // renommage
        $randomName = ByteString::fromRandom(32)->lower();
        $extension = $file->guessClientExtension();

        $this->fileName = "$randomName.$extension";

        // transfert du fichier
        $file->move($directory, $this->fileName);
    }

    public function delete(string $directory, string $file): void
    {
        unlink($directory.$file);
    }

}