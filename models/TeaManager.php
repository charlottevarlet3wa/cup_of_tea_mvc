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
        $stmt = $this->db->prepare("SELECT categorie.nom as nomCat, thes.image, thes.nom, thes.id, thes.id_category, FORMAT(MIN(prix), 2) as prix FROM thes 
        INNER JOIN format ON thes.id = format.id_the
        INNER JOIN categorie ON categorie.id = thes.id_category
        GROUP BY format.id_the");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCategories(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM categorie");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTeaById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM thes WHERE id = ?");
        $stmt->execute([$id]);
        $tea = $stmt->fetch(PDO::FETCH_ASSOC);
        return $tea ?: null;
    }

    public function getFormatsByTea(int $id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM format WHERE id_the = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCdC(): array
    {
        $stmt = $this->db->prepare("SELECT thes.sous_titre, thes.description, thes.image, thes.nom, thes.id, thes.id_category, FORMAT(MIN(prix), 2) as prix FROM thes 
        INNER JOIN format ON thes.id = format.id_the
        WHERE thes.coup_de_coeur = 1
        GROUP BY format.id_the");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNouv(): array
    {
        $stmt = $this->db->prepare("SELECT thes.sous_titre, thes.description, thes.image, thes.nom, thes.id, thes.id_category, FORMAT(MIN(prix), 2) as prix FROM thes 
        INNER JOIN format ON thes.id = format.id_the
        GROUP BY format.id_the ORDER BY date DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBs(): array
    {
        $stmt = $this->db->prepare("SELECT thes.sous_titre, thes.description, thes.image, thes.nom, thes.id, thes.id_category, FORMAT(MIN(prix), 2) as prix FROM thes 
        INNER JOIN format ON thes.id = format.id_the
        WHERE thes.id = (SELECT product_id FROM orderdetail GROUP BY product_id ORDER BY COUNT(product_id) DESC LIMIT 1)
        GROUP BY format.id_the ORDER BY date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // La méthode addTea() serait à implémenter selon les besoins spécifiques de l'application
}
