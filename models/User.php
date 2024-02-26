<?php
class User {
    private $id;
    private $name;
    private $email;
    // Autres propriétés liées à l'utilisateur

    public function __construct($id, $name, $email) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    // Getters et setters pour les propriétés
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    // Méthodes métier spécifiques à l'utilisateur
    public function validateEmail() {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

}