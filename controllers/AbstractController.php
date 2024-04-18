<?php 

abstract class AbstractController{

    function calculateTotal() {
      $total = 0;
      foreach($_SESSION['cart'] as $tea){
        foreach($tea['formats'] as $format){
            $total += $format['price'] * $format['quantity'];
        }
    }
      return number_format($total, 2);
  }

  function getCartCount(){
    $count = 0;
    foreach($_SESSION['cart'] as $tea){
      foreach($tea['formats'] as $format){
        $count += $format['quantity'];
      }
    }
    return $count;
  }
}