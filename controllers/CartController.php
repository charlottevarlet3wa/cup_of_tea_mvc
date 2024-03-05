<?php 



class CartController {
    public function display() {
        $template = "cart.phtml";
        require_once "views/layout.phtml";
    }
    public function displayCart(){
        $cart = $_SESSION['cart'];
        $cartHtml = "";

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
                $cartHtml .= "<td>" . htmlspecialchars($format['price']) . "€</td>";
                $cartHtml .= "<td>" . htmlspecialchars($format['quantity'] * $format['price']) . "€</td>";
                $cartHtml .= '<td><button onclick="changeQuantity(' . htmlspecialchars($teaId) . ', ' . htmlspecialchars($formatId) . ', 0)">Remove</button></td>';
                $cartHtml .= "</tr>";
                $formatIndex++;
                $index++;
                $total += $format['price'] * $format['quantity'];
            }
            $teaIndex++;
        }
        $cartHtml .= "<tr>";
        $cartHtml .= "<td>Total</td>";
        $cartHtml .= "<td style='background-color:#F2F2F2' colspan='4'></td>";
        $cartHtml .= "<td>";
        $cartHtml .= $total . "€";
        $cartHtml .= "</td>";
        $cartHtml .= "</tr>";
    
        echo $cartHtml;
    }
    
}