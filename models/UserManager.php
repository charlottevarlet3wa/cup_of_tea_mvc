<?php

// TODO : test

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class UserManager extends AbstractModel
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser(int $id, string $nom, string $prenom, string $email, string $password): bool
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

        $stmt = $this->db->prepare("UPDATE user SET nom = ?, prenom = ?, email = ?, password = ? WHERE id = ?");
        return $stmt->execute([$nom, $prenom, $email, $passwordHash, $id]);
    }

    public function addUser(string $nom, string $prenom, string $email, string $password): bool
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

        $stmt = $this->db->prepare("INSERT INTO user (nom, prenom, email, password, admin) VALUES (?, ?, ?, ?, 0)");
        return $stmt->execute([$nom, $prenom, $email, $passwordHash]);
    }

    // TODO : authentication system

}