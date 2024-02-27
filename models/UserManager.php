<?php

// TODO : test

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class UserManager extends AbstractModel
{
    protected $db;

    public function __construct() {
        $this->db = getConnection();
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser(int $id, string $last_name, string $name, string $email, string $password): bool
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

        $stmt = $this->db->prepare("UPDATE user SET last_name = ?, name = ?, email = ?, password = ? WHERE id = ?");
        return $stmt->execute([$last_name, $name, $email, $passwordHash, $id]);
    }

    public function addUser(string $last_name, string $name, string $email, string $password): bool
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

        $stmt = $this->db->prepare("INSERT INTO user (last_name, name, email, password, admin) VALUES (?, ?, ?, ?, 0)");
        return $stmt->execute([$last_name, $name, $email, $passwordHash]);
    }

    public function loginUser(string $email, string $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, return user data
            return $user;
        }

        // Email not found or password does not match
        return false;
    }

}