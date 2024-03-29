<?php

require_once 'models/User.php';
require_once 'models/UserManager.php';

require_once 'models/Order.php';
require_once 'models/OrderManager.php';



class TestController { 

    // public function setStatus($isStatus){
    //     // echo "status : " . $isStatus;
    //     $manager = new OrderManager();
    //     $manager->updateStatus(2, $isStatus);
    // }

    public function updateStatus($orderId, $filter){
        // echo "order id : " . $orderId .  " _ filter : " . $filter;
        $manager = new OrderManager();
        $manager->updateStatus($orderId);
        $this->filterOrders($filter);
    }

    // public function updateStatus($orderId, $isStatus){
    //     $manager = new OrderManager();
    //     $manager->updateStatus($orderId, $isStatus);
    // }

    // TODO : $filter = 0 "all", 1 "unchecked" ou 2 "checked"
    public function filterOrders($filter){
        $filteredOrdersHtml = '';
        
        $manager = new OrderManager();
        $orders = $manager->getAllOrders();
        
        foreach ($orders as $order) {
            // Apply filter
            $includeOrder = false;
            switch ($filter) {
                case 'all':
                    $includeOrder = true;
                    break;
                case 'processed':
                    if ($order['status'] == 1) {
                        $includeOrder = true;
                    }
                    break;
                case 'unprocessed':
                    if ($order['status'] == 0) {
                        $includeOrder = true;
                    }
                    break;
            }
            
            if ($includeOrder) {
                // Generate HTML for each order
                $filteredOrdersHtml .= "<tr>";
                $filteredOrdersHtml .= "<td>" . htmlspecialchars($order['id']) . "</td>";
                $filteredOrdersHtml .= "<td>" . (new DateTime($order['date']))->format('Y-m-d H:i:s') . "</td>";
                $filteredOrdersHtml .= "<td>" . htmlspecialchars($order['name']) . " " . htmlspecialchars($order['last_name']) . "</td>";
                $filteredOrdersHtml .= "<td>" . htmlspecialchars(number_format((float)$order['total'], 2, '.', '')) . " €</td>";
                $filteredOrdersHtml .= "<td>" . 
                '<form id="statusForm" method="POST">
                    <input type="checkbox" class="order-status" name="status" onchange=updateStatus('. $order['id'] .') ' . ($order['status'] == 1 ? "checked" : "" ) . ' >
                    <input type="hidden" name="orderId" >
                </form>' . "</td>";
                $filteredOrdersHtml .= "<td><button onclick=showDetails(". $order['id'] .") class='btn'>Voir le détail</button></td>";
                $filteredOrdersHtml .= "</tr>";
            }
        }
        
        // Output the filtered orders HTML
        echo $filteredOrdersHtml;
    }

    public function showDetails($orderId){
        $manager = new OrderManager();
        $details = $manager->getOrderDetailsById($orderId);
        $detail = $details[0];


        $detailsHtml = "";

        $detailsHtml .= "<h2>Détail de la commande n° " . htmlspecialchars($detail['order_id']) . "</h2>";
        $detailsHtml .= "<p>Passée le " . (new DateTime($detail['date']))->format('Y-m-d H:i:s') . "</p>";
        $detailsHtml .= "<p><strong>Informations client : </strong>" . htmlspecialchars($detail['user_name']) . " " . htmlspecialchars($detail['user_last_name']) . "</p>";
        // TODO : vérifier que le texte sur le statut est bien comme l'original
        $detailsHtml .= "<p>Statut:" . $detail['order_status'] == 1 ? 'Traitée' : 'Non traitée' . "</p>";
        // $detailsHtml .= "<p><strong>Details : </strong></p>" . details.map((detail, i ) => <p>{detail.nom} - {detail.cond} - {detail.price.toFixed(2)}. " €</p>";
        $detailsHtml .= "<p><strong>Details : </strong></p>";
        foreach($details as $detail){
            $detailsHtml .= "<p>". $detail['name'] . " - " . $detail['cond'] . " - " . $detail['price'] ."€</p>";
        }
        $detailsHtml .= "<button class='btn' onclick=showList()>Retour à la liste</button>";
        // $detailsHtml .= "<button class='btn' onclick={retour}>Retour à la liste</button>";

        echo $detailsHtml;
    }
        
}
    
