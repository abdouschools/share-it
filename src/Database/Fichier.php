<?php

namespace App\Database;

/**
 * les obket de la table class fichier representent les donnes de la table fichier  dans la base des donneess my sql
 * 1instance= 1ligne
 */
class Fichier
{
    private ?int $id = null;
    private  ?string $nom = null;
    private ?string $nom_original = null;
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }
    public function getNomOriginal(): ?string
    {
        return $this->nom_original;
    }
    public function setNomOriginal(string $nomorig): self
    {
        $this->nom = $nomorig;
        return $this;
    }
}
