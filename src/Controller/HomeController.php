<?php

namespace App\Controller;

use App\Database\FichierManager;
use App\File\UploadService;
use Doctrine\DBAL\Connection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class HomeController extends AbstractController
{
    public function homepage(
        ResponseInterface $response,
        ServerRequestInterface $request,
        UploadService $uploadService,
        FichierManager $fichierManager

    ) {
        // Récupérer les fichiers envoyés:
        $listeFichiers = $request->getUploadedFiles();

        // Si le formulaire est envoyé
        if (isset($listeFichiers['fichier'])) {
            /** @var UploadedFileInterface $fichier */
            $fichier = $listeFichiers['fichier'];
            //recupere le nouveau nom du fichier
            $nouveauNom = $uploadService->saveFile($fichier);
            $fichier = $fichierManager->createFichier($nouveauNom, $fichier->getClientFilename());
            return $this->redirect('success', [
                'id' => $fichier->getId()
            ]);
        }

        return $this->template($response, 'home.html.twig');
    }
    public function success(ResponseInterface $response, int $id, FichierManager $fichierManager)
    {
        $fichier = $fichierManager->getById($id);
        if ($fichier === null) {
            return $this->redirect('fileError');
        }

        return $this->template($response, 'success.html.twig', [
            'fichier' => $fichier
        ]);
    }
    public function fileError(ResponseInterface $response)
    {
        return $this->template($response, 'fileError.html.twig');
    }

    //public function download(ResponseInterface $response,  int $id)
    //{
    //$response->getBody()->write(sprintf('Identifiant: %d', $id));
    //return $response;
    //}
    public function download(ResponseInterface $response,  int $id, FichierManager  $fichierManager)
    {
        $fichier = $fichierManager->getById($id);
        if ($fichier === null) {
            return $this->redirect('fichierError');
        }
        $origName = $fichier->getNomOriginal();
        $fichierName = $fichier->getNom();
        $pathFileName = __DIR__ . '/../../files/' . $fichierName;
        if (file_exists($pathFileName)) {
            header('Content-Type:' . mime_content_type($pathFileName));
            header('Content-Description: transfer de fichier');
            header('Content-Disposition : attachment;filename= ' . basename($pathFileName) . "-");
            readfile($pathFileName);
            exit;
        }
        return $response;
    }
}
