<?php

// TODO : test

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class Order extends AbstractModel
{
    public function __construct(
        private ?DateTime $date = null,
        private ?int $user_id = null,
        private ?int $status = 0,
        ?int $id = null
    ) {
        parent::__construct($id);
        // Si aucune date n'est fournie, utiliser la date et l'heure actuelles
        if ($this->date === null) {
            $this->date = new DateTime();
        }
    }

    // Accesseurs et mutateurs
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(?DateTime $date): void
    {
        $this->date = $date;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    // Validation des données de la commande
    public function validate(): array
    {
        $errors = [];

        if ($this->user_id === null || $this->user_id <= 0) {
            $errors[] = "L'identifiant de l'utilisateur est invalide.";
        }

        if ($this->status < 0 || $this->status > 1) { // Exemple de validation, ajustez selon vos besoins
            $errors[] = "Le statut spécifié est invalide.";
        }

        return $errors;
    }
}
