<?php

// TODO : test

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';

class TeaManager extends AbstractModel
{
    protected $db;

    public function __construct()
    {
        $this->db = getConnection();
    }

    public function getAllTeas(): array
    {
        $stmt = $this->db->prepare("SELECT category.name as catName, tea.image, tea.name, tea.id, tea.category_id, FORMAT(MIN(price), 2) as price FROM tea 
        INNER JOIN format ON tea.id = format.tea_id
        INNER JOIN category ON category.id = tea.category_id
        GROUP BY format.tea_id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCategories(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM category");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTeaById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM tea WHERE id = ?");
        $stmt->execute([$id]);
        $tea = $stmt->fetch(PDO::FETCH_ASSOC);
        return $tea ?: null;
    }

    public function getFormatsByTea(int $id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM format WHERE tea_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFavorite(): array
    {
        $stmt = $this->db->prepare("SELECT tea.subtitle, tea.description, tea.image, tea.name, tea.id, tea.category_id, FORMAT(MIN(price), 2) as price FROM tea 
        INNER JOIN format ON tea.id = format.tea_id
        WHERE tea.favorite = 1
        GROUP BY format.tea_id");
        $stmt->execute();
        // $results = $stmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($results);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLatest(): array
    {
        $stmt = $this->db->prepare("SELECT tea.subtitle, tea.description, tea.image, tea.name, tea.id, tea.category_id, FORMAT(MIN(price), 2) as price FROM tea 
        INNER JOIN format ON tea.id = format.tea_id
        GROUP BY format.tea_id ORDER BY date DESC LIMIT 1");
        $stmt->execute();
        // return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function getBestseller(): array
    {
        // $stmt = $this->db->prepare("SELECT tea.subtitle, tea.description, tea.image, tea.name, tea.id, tea.category_id, FORMAT(MIN(price), 2) as price FROM tea 
        // INNER JOIN format ON tea.id = format.tea_id
        // WHERE tea.id = (SELECT product_id FROM order_details GROUP BY product_id ORDER BY COUNT(product_id) DESC LIMIT 1)
        // GROUP BY format.tea_id ORDER BY date DESC");

        $stmt = $this->db->prepare("SELECT tea.subtitle, tea.description, tea.image, tea.name, tea.id, tea.category_id, FORMAT(MIN(format.price), 2) as price 
        FROM tea
        INNER JOIN format ON tea.id = format.tea_id
        -- WHERE tea.id = (SELECT product_id FROM order_details GROUP BY product_id ORDER BY COUNT(product_id) DESC LIMIT 1)
        GROUP BY tea.id;");
        
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        var_dump($results);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // La méthode addTea() serait à implémenter selon les besoins spécifiques de l'application
}
