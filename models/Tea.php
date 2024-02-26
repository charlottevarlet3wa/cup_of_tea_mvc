<?php

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class Tea extends AbstractModel
{
    public function __construct(
        private ?string $name = null,
        private ?string $subtitle = null,
        private ?string $description = null,
        private ?string $image = null,
        private int $category_id,
        private int $favorite = 0,
        ?int $id = null
    ) {
        parent::__construct($id);
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

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    public function getFavorite(): int
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
