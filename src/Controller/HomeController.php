<?php

namespace App\Controller;

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
        Connection $connection

    ) {
        // Récupérer les fichiers envoyés:
        $listeFichiers = $request->getUploadedFiles();

        // Si le formulaire est envoyé
        if (isset($listeFichiers['fichier'])) {
            /** @var UploadedFileInterface $fichier */
            $fichier = $listeFichiers['fichier'];
            //recupere le nouveau nom du fichier
            $nouveauNom = $uploadService->saveFile($fichier);
            $connection->insert('fichier', [
                'nom' => $nouveauNom,
                'nom_original' => $fichier->getClientFilename()
            ]);
            //enregistre le infos sur la base de donnes 
        }

        return $this->template($response, 'home.html.twig');
    }

    public function download(ResponseInterface $response, int $id)
    {
        $response->getBody()->write(sprintf('Identifiant: %d', $id));
        return $response;
    }
}
