<?php

namespace App\File;

use Psr\Http\Message\UploadedFileInterface;

/**
 *service responsable denrgstrmnt fichiers 
 */
class UploadService
{
    /**
     * @var string chemin vers le dossie  ou enregistrer les fichies
     */
    public const FILES_DIR = __DIR__ . '/../../files';
    /**
     * @param UploadedFileInterface $file le fichier charge a enregistrer
     * @return string le nouveau nom du fichier ou null en cas d"erreur  
     */

    public function saveFile(UploadedFileInterface $file): string
    {
        $filename = $this->generateFilename($file);
        $path = self::FILES_DIR . '/' . $filename;
        $file->moveTo($path);
        return $filename;
    }
    private function generateFilename(UploadedFileInterface $file): string
    {
        $filename = date('YmdHis');
        $filename .= bin2hex(random_bytes(8));
        $filename .= '.' . pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        return $filename;
    }
}
