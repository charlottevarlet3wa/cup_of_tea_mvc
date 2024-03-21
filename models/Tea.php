<?php

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class Tea extends AbstractModel
{
    public function __construct(
        private int $category_id,
        private string $name,
        private string $subtitle,
        private string $image,
        private string $description,
        private string $reference,
        private string $date,
        private int $stock = 50, // TODO : input avec stock pour enlever la valeur par défaut
        private bool $favorite = false,
        ?int $id = null
        ) {
            parent::__construct($id);
        }
        
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    // Accesseurs et mutateurs
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): void
    {
        $this->reference = $reference;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): void
    {
        $this->stock = $stock;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): void
    {
        $this->date = $date;
    }


    public function getFavorite(): bool
    {
        return $this->favorite;
    }

    public function setFavorite(int $favorite): void
    {
        $this->favorite = $favorite;
    }

    // Vous pouvez ajouter ici des méthodes spécifiques à la gestion des thés,
    // comme des validations ou des opérations de base de données.
}
