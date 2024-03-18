<?php

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class Address extends AbstractModel
{
    public function __construct(
        private ?int $user_id = null,
        private string $street_number = '',
        private string $street_name = '',
        private int $postal_code = 0,
        private string $town = '',
        private string $country = '',
        ?int $id = null
    ) {
        parent::__construct($id);
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getStreetNumber(): ?string
    {
        return $this->street_number;
    }

    public function setStreetNumber(?string $street_number): void
    {
        $this->street_number = $street_number;
    }

    public function getStreetName(): ?string
    {
        return $this->street_name;
    }

    public function setStreetName(?string $street_name): void
    {
        $this->street_name = $street_name;
    }

    public function getPostalCode(): ?int
    {
        return $this->postal_code;
    }

    public function setPostalCode(?int $postal_code): void
    {
        $this->postal_code = $postal_code;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(?string $town): void
    {
        $this->town = $town;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    // Validation
    public function validate(): array
    {
        $errors = [];
        if ($this->user_id === null || $this->user_id <= 0) {
            $errors[] = "User ID is invalid or missing.";
        }
        
        if (empty($this->street_number)) {
            $errors[] = "Le numéro de rue est obligatoire.";
        }

        if (empty($this->street_name)) {
            $errors[] = "Le nom de rue est obligatoire.";
        }

        if ($this->postal_code <= 0) {
            $errors[] = "Le code postal est invalide.";
        }

        if (empty($this->town)) {
            $errors[] = "La ville est obligatoire.";
        }

        if (empty($this->country)) {
            $errors[] = "Le pays est obligatoire.";
        }

        return $errors;
    }
}
