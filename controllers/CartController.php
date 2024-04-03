<?php 

class CartController {
    public function display() {
        $cart = $_SESSION['cart'] ?? null;
        $template = "cart.phtml";
        require_once "views/layout.phtml";
    }
    

    public function displayCart() {
        $cart = $_SESSION['cart'];
        
        if (empty($cart)) {
            echo "empty";
            return;
        }
        
        $cartHtml = "<thead>
            <tr>
                <th></th>
                <th>Produit</th>
                <th>Format</th>
                <th>Quantité</th>
                <th>Prix Unit.</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>";
        
        $total = 0;
        $index = 0;
        $indexTable = 1;
        foreach ($cart as $teaId => $tea) {
            foreach ($tea['formats'] as $formatId => $format) {
                $selectOptions = '';
                for ($i = 1; $i <= 10; $i++) {
                    $selected = $i == $format['quantity'] ? 'selected' : '';
                    $selectOptions .= "<option value=\"{$i}\" {$selected}>{$i}</option>";
                }
                $teaName = htmlspecialchars($tea['name']);
                $formatName = htmlspecialchars($format['format']);
                $priceFormatted = number_format(htmlspecialchars($format['price']), 2);
                $totalFormatted = number_format(htmlspecialchars($format['quantity'] * $format['price']), 2);
    
                $cartHtml .= "<tr>
                    <td>{$indexTable}</td>
                    <td>{$teaName}</td>
                    <td>{$formatName}</td>
                    <td><select name=\"quantity-select\" onchange=\"changeQuantity({$teaId}, {$formatId}, this.value)\">{$selectOptions}</select></td>
                    <td>{$priceFormatted}€</td>
                    <td>{$totalFormatted}€</td>
                    <td><button class=\"btn grey-btn\" onclick=\"changeQuantity({$teaId}, {$formatId}, 0)\">X</button></td>
                </tr>";
                $index++;
                $indexTable++;
                $total += $format['price'] * $format['quantity'];
            }
        }
    
        $totalFormatted = number_format($total, 2);
    
        $cartHtml .= "</tbody>
        <tfoot>
            <tr class='total'>
                <td colspan='5'></td>
                <td>{$totalFormatted}€</td>
            </tr>
        </tfoot>";
    
        echo $cartHtml;
    }
    
    
    
}