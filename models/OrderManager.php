<?php

declare(strict_types=1);

require_once 'services/database.php';
require_once 'models/AbstractModel.php';


class OrderManager extends AbstractModel
{
    protected $db;

    public function __construct()
    {
        $this->db = getConnection(); // Assuming you have a static method to get the DB connection
    }

    public function addOrder($userId, $teas): bool
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare('INSERT INTO `order` (date, user_id) VALUES (NOW(), ?)');
            $stmt->execute([$userId]);
            $orderId = $this->db->lastInsertId();

            foreach ($teas as $tea) {
                $stmt = $this->db->prepare('INSERT INTO order_details (order_id, product_id, cond, price) VALUES (?, ?, ?, ?)');
                $stmt->execute([$orderId, $tea['id'], $tea['qte'], $tea['price']]);
                // TODO what is "qte" ? "quantity" ?
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            // Handle exception or log error
            return false;
        }
    }

    public function getAllOrders(): array
    {
        // TODO check why doubles keys ('name' => 'John', 0 => 'John');
        $stmt = $this->db->query("SELECT `order`.status, user.last_name, user.name, `order`.date, `order`.id, SUM(price) as total FROM `order` INNER JOIN order_details ON `order`.id = order_details.order_id INNER JOIN user ON user.id = `order`.user_id GROUP BY order_id ORDER BY `order`.id DESC");
        return $stmt->fetchAll();
    }

    public function updateStatus($orderId, $status): bool
    {
        $stmt = $this->db->prepare("UPDATE `order` SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $orderId]);
    }

    public function getOrderByUser($userId): array
    {
        $stmt = $this->db->prepare("SELECT date, `order`.id, SUM(price) as total FROM `order` INNER JOIN order_details ON `order`.id = order_details.order_id WHERE user_id = ? GROUP BY order_id ORDER BY `order`.id DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getOrderDetailsById($orderId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM `order_details` INNER JOIN tea ON product_id = tea.id WHERE order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }

    public function getOrderById($orderId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `order` INNER JOIN user ON `order`.user_id = user.id WHERE `order`.id = ?");
        $stmt->execute([$orderId]);
        $order = $stmt->fetch();
        return $order ?: null;
    }
}
