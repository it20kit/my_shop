<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

interface FileServiceInterface
{
    public function getFileFromRequest(Request $request): UploadedFile;

    public function saveFile(UploadedFile $file, string $failName): void;

    public function getUpdateNameFile(UploadedFile $file): string;

}