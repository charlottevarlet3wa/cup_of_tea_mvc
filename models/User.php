<?php

class User {
    private $id;
    private $last_name;
    private $name;
    private $email;
    private $password; // Consider this property's visibility regarding security
    private $admin;

    public function __construct($id, $last_name, $name, $email, $password, $admin) {
        $this->id = $id;
        $this->last_name = $last_name;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->admin = $admin;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function isAdmin() {
        return $this->admin == 1;
    }

    // Setters
    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        if ($this->validateEmail($email)) {
            $this->email = $email;
        }
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    public function setAdmin($admin) {
        $this->admin = $admin;
    }

    // Email validation method
    public function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
