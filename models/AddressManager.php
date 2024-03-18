<?php

declare(strict_types=1);

require_once 'services/database.php';

class AddressManager
{
    protected $db;

    public function __construct()
    {
        $this->db = getConnection();
    }

    public function addAddress($userId, $streetNumber, $streetName, $postalCode, $town, $country): bool
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO address (user_id, street_number, street_name, postal_code, town, country) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$userId, $streetNumber, $streetName, $postalCode, $town, $country]);
            return true;
        } catch (Exception $e) {
            // Handle exception or log error
            return false;
        }
    }
}
