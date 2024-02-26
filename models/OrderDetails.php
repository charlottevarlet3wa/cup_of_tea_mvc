<?php

// TODO : test

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class OrderDetails extends AbstractModel
{
    public function __construct(
        private ?int $order_id = null,
        private ?int $product_id = null,
        private ?string $cond = null,
        private ?float $price = null,
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    // Accesseurs et mutateurs
    public function getOrderId(): ?int
    {
        return $this->order_id;
    }

    public function setOrderId(?int $order_id): void
    {
        $this->order_id = $order_id;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(?int $product_id): void
    {
        $this->product_id = $product_id;
    }

    public function getCond(): ?string
    {
        return $this->cond;
    }

    public function setCond(?string $cond): void
    {
        $this->cond = $cond;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    // Validation des données de détails de commande
    public function validate(): array
    {
        $errors = [];

        if ($this->order_id === null) {
            $errors[] = "L'ID de la commande ne peut pas être nul.";
        }

        if ($this->product_id === null) {
            $errors[] = "L'ID du produit ne peut pas être nul.";
        }

        if (empty($this->cond)) {
            $errors[] = "Le conditionnement ne peut pas être vide.";
        }

        if ($this->price <= 0) {
            $errors[] = "Le prix doit être supérieur à 0.";
        }

        return $errors;
    }
}
