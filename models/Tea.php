<?php

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class Tea extends AbstractModel
{
    public function __construct(
        private ?string $nom = null,
        private ?string $sous_titre = null,
        private ?string $description = null,
        private ?string $image = null,
        private int $id_category,
        private int $coup_de_coeur = 0,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    // Accesseurs et mutateurs
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function getSousTitre(): ?string
    {
        return $this->sous_titre;
    }

    public function setSousTitre(?string $sous_titre): void
    {
        $this->sous_titre = $sous_titre;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getIdCategory(): int
    {
        return $this->id_category;
    }

    public function setIdCategory(int $id_category): void
    {
        $this->id_category = $id_category;
    }

    public function getCoupDeCoeur(): int
    {
        return $this->coup_de_coeur;
    }

    public function setCoupDeCoeur(int $coup_de_coeur): void
    {
        $this->coup_de_coeur = $coup_de_coeur;
    }

    // Vous pouvez ajouter ici des méthodes spécifiques à la gestion des thés,
    // comme des validations ou des opérations de base de données.
}
