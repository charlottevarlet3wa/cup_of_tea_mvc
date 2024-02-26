<?php

// TODO : test

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class Format extends AbstractModel
{
    public function __construct(
        private ?int $id_the = null,
        private ?string $conditionnement = null,
        private ?float $prix = null,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    // Accesseurs et mutateurs
    public function getIdThe(): ?int
    {
        return $this->id_the;
    }

    public function setIdThe(?int $id_the): void
    {
        $this->id_the = $id_the;
    }

    public function getConditionnement(): ?string
    {
        return $this->conditionnement;
    }

    public function setConditionnement(?string $conditionnement): void
    {
        $this->conditionnement = $conditionnement;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): void
    {
        $this->prix = $prix;
    }

    // Validation des données du format
    public function validate(): array
    {
        $errors = [];

        if (empty($this->conditionnement)) {
            $errors[] = "Le conditionnement ne peut pas être vide.";
        }

        if ($this->prix <= 0) {
            $errors[] = "Le prix doit être supérieur à 0.";
        }

        return $errors;
    }
}
