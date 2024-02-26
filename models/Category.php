<?php

// TODO : test

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class Category extends AbstractModel
{
    public function __construct(
        private ?string $name = null,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    // Accesseur et mutateur pour le name de la catégorie
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    // Validation des données de la catégorie
    public function validate(): array
    {
        $errors = [];

        // Validation du name
        if (empty($this->name)) {
            $errors[] = "Le name de la catégorie ne doit pas être vide.";
        } elseif (strlen($this->name) > 255) {
            $errors[] = "Le name de la catégorie ne doit pas excéder 255 caractères.";
        }

        return $errors;
    }
}
