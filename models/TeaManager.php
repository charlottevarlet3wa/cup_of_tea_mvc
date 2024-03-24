<?php

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
        // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($result);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCategories(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM category");
        $stmt->execute();
        // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($result);
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
        $stmt = $this->db->prepare("SELECT tea.subtitle, tea.description, tea.image, tea.name, tea.id, tea.category_id, FORMAT(MIN(format.price), 2) as price 
        FROM tea
        INNER JOIN format ON tea.id = format.tea_id
        WHERE tea.id = (SELECT product_id FROM order_details GROUP BY product_id ORDER BY COUNT(product_id) DESC LIMIT 1)
        GROUP BY tea.id;");
        
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($results[0]);
        // return $stmt->fetchAll(PDO::FETCH_ASSOC)[0]; // marche pas
        return $results[0];
    }

    public function addTea($reference, $name, $subtitle, $description, $imagePath, $categoryId, $stock, $isFavorite, $formatPrices, $formatConditionings)
    {

    // Begin transaction to ensure both tea and formats are added successfully
    $this->db->beginTransaction();

    try {
        // Insert tea
        $stmt = $this->db->prepare("INSERT INTO `tea` (`category_id`, `name`, `subtitle`, `description`, `image`, `reference`, `stock`, `favorite`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_DATE())");
        $stmt->execute([$categoryId, $name, $subtitle, $description, $imagePath, $reference, $stock, $isFavorite]);
        
        // Get the last inserted tea ID
        $teaId = $this->db->lastInsertId();
        
        // Prepare statement for inserting formats
        $stmtFormat = $this->db->prepare("INSERT INTO `format` (`tea_id`, `price`, `conditioning`) VALUES (?, ?, ?)");
        
        // Insert each format for the tea
        // foreach ($formats as $format) {
        //     $stmtFormat->execute([$teaId, $format['price'], $format['conditioning']]);
        // }

        for($i = 0; $i < count($formatPrices); $i++){
            if(!empty($formatPrices[$i] && !empty($formatConditionings[$i]))){
                $stmtFormat->execute([$teaId, $formatPrices[$i], $formatConditionings[$i]]);
            }
        }

        // If everything is fine, commit transaction
        $this->db->commit();
        
        return $teaId;
    } catch (Exception $e) {
        // In case of error, rollback the transaction
        $this->db->rollBack();
        // Log error or handle it as per your application's requirement
        error_log($e->getMessage());
        return $e;
    }
    }


    public function addFormat($teaId, $price, $conditioning) {
        try {
            // Prepare the SQL statement
            $stmt = $this->db->prepare("INSERT INTO `format` (`tea_id`, `price`, `conditioning`) VALUES (:teaId, :price, :conditioning)");
    
            // Bind the parameters
            $stmt->bindParam(':teaId', $teaId, PDO::PARAM_INT);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':conditioning', $conditioning);
    
            // Execute the statement and return the result
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle or log the error as needed
            $error = "Failed to add format: " . $e->getMessage();
            return $error;
        }
    }
}


