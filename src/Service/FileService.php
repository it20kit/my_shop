<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class FileService implements FileServiceInterface
{

    public function  __construct(private ParameterBagInterface $parameterBag)
    {

    }

    public function getFileFromRequest(Request $request): UploadedFile
    {
        $array = $request->files->get('add_product');
        return $array['image'];
    }

    public function saveFile(UploadedFile $file, string $failName): void
    {
        $path = $this->parameterBag->get('kernel.project_dir') . '/public/uploads';
        $file->move($path, $failName);
    }

    public function getUpdateNameFile(UploadedFile $file): string
    {
        return uniqid() . '_' .  $file->getClientOriginalName();
    }
}