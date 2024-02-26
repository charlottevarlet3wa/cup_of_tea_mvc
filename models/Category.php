<?php

// TODO : test

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class Category extends AbstractModel
{
    public function __construct(
        private ?string $nom = null,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    // Accesseur et mutateur pour le nom de la catégorie
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    // Validation des données de la catégorie
    public function validate(): array
    {
        $errors = [];

        // Validation du nom
        if (empty($this->nom)) {
            $errors[] = "Le nom de la catégorie ne doit pas être vide.";
        } elseif (strlen($this->nom) > 255) {
            $errors[] = "Le nom de la catégorie ne doit pas excéder 255 caractères.";
        }

        return $errors;
    }
}
