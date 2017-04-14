<?php
// src/AppBundle/FileUploader.php
namespace AppBundle;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file, $fileName, $type)
    {
        $fileName .= '.' . $file->guessExtension();
        $target = $this->targetDir . '/' . $type;

        $file->move($target, $fileName);

        return "http://apifreshdj.cloudapp.net/uploads/" . $type . '/' . $fileName;
    }
}
