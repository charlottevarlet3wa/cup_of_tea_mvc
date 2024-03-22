<?php 



class CartController {
    public function display() {
        $template = "cart.phtml";
        require_once "views/layout.phtml";
    }
    
    public function displayCart(){
        $cart = $_SESSION['cart'];
        
        $cartHtml = "";
        
        if(empty($cart)){
            echo "empty";
            return;
        }

        $cartHtml .= "<thead>";
        $cartHtml .= "<tr>";
        $cartHtml .= "<th></th>";
        $cartHtml .= "<th>Produit</th>";
        $cartHtml .= "<th>Format</th>";
        $cartHtml .= "<th>Quantité</th>";
        $cartHtml .= "<th>Prix Unit.</th>";
        $cartHtml .= "<th>Total</th>";
        $cartHtml .= "<th></th>";
        $cartHtml .= "</tr>";
        $cartHtml .= "</thead>";
        $cartHtml .= "<tbody>";
        
        $total = 0;
        $index = 0;
        $teaIndex = 0;
        foreach ($cart as $teaId => $tea){
            $formatIndex = 0;
            foreach ($tea['formats'] as $formatId => $format){
                $cartHtml .= "<tr>";
                $cartHtml .= "<td>" . htmlspecialchars($index) . "</td>";
                $cartHtml .= "<td>" . htmlspecialchars($tea['name']) . "</td>";
                $cartHtml .= "<td>" . htmlspecialchars($format['format']) . "</td>";
                $cartHtml .= "<td>";
                $cartHtml .= '<select name="quantity-select" onchange="changeQuantity(' . htmlspecialchars($teaId) . ', ' . htmlspecialchars($formatId) . ', this.value)">';
                for($i=1; $i <= 10; $i++){
                    $selected = $i == $format['quantity'] ? 'selected' : '';
                    $cartHtml .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                }
                $cartHtml .= "</select>";
                $cartHtml .= "</td>";
                $cartHtml .= "<td>" . number_format(htmlspecialchars($format['price']), 2) . "€</td>";
                $cartHtml .= "<td>" . number_format(htmlspecialchars($format['quantity'] * $format['price']), 2) . "€</td>";
                $cartHtml .= '<td style="background-color: #F2F2F2"><button class="btn grey-btn" onclick="changeQuantity(' . htmlspecialchars($teaId) . ', ' . htmlspecialchars($formatId) . ', 0)">X</button></td>';
                $cartHtml .= "</tr>";
                $formatIndex++;
                $index++;
                $total += $format['price'] * $format['quantity'];
            }
            $teaIndex++;
        }
        $cartHtml .= "</tbody>";
        $cartHtml .= "<tfoot>";
        $cartHtml .= "<tr class='total'>";
        // $cartHtml .= "<td>Total</td>";
        $cartHtml .= "<td style='background-color:#F2F2F2' colspan='5'></td>";
        $cartHtml .= "<td>";
        $cartHtml .= number_format($total, 2) . "€";
        $cartHtml .= "</td>";
        $cartHtml .= "</tr>";
        $cartHtml .= "</tfoot>";
    
        echo $cartHtml;
    }
    
}