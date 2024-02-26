<?php

// TODO : test

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class Format extends AbstractModel
{
    public function __construct(
        private ?int $tea_id = null,
        private ?string $conditioning = null,
        private ?float $price = null,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    // Accesseurs et mutateurs
    public function getTeaId(): ?int
    {
        return $this->tea_id;
    }

    public function setTeaId(?int $tea_id): void
    {
        $this->tea_id = $tea_id;
    }

    public function getConditioning(): ?string
    {
        return $this->conditioning;
    }

    public function setConditioning(?string $conditioning): void
    {
        $this->conditioning = $conditioning;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    // Validation des données du format
    public function validate(): array
    {
        $errors = [];

        if (empty($this->conditioning)) {
            $errors[] = "Le conditionnement ne peut pas être vide.";
        }

        if ($this->price <= 0) {
            $errors[] = "Le prix doit être supérieur à 0.";
        }

        return $errors;
    }
}
