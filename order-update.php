<?php
session_start();
require_once('essentials/config.php');
date_default_timezone_set('Asia/Kolkata');

  $customer = $_SESSION['email'];  
  $shipping = $_SESSION['shipping'];


if(isset($_SESSION['cart'])) {

  $total = 0;
  $itemqty = 0;

  $query = $connect->query("INSERT INTO orders(customer,shipping_id,status,total_amt,total_qty,payment_type,created_date,modified_date) 
                           VALUES('$customer','$shipping',1,0,0,'COD',NOW(),NOW())");

  $order_id = mysqli_insert_id($connect);
  echo $order_id;

  foreach($_SESSION['cart'] as $product_id => $quantity) {

    $result = $connect->query("SELECT * FROM product WHERE id = ".$product_id);

    if($result){

      if($obj = $result->fetch_object()) {

        $cost = $obj->cost * $quantity;
        $total = $total + $cost;
        $itemqty = $itemqty+$quantity; 

        $query2 = $connect->query("INSERT INTO order_items (order_id,product_id, product_name, price, units, total, customer) 
                                 VALUES('$order_id','$obj->id', '$obj->name', $obj->cost, $quantity, $cost, '$customer')");


        if($query2){
          $newqty = $obj->qty - $quantity;
          if($connect->query("UPDATE product SET qty = ".$newqty." WHERE id = ".$product_id)){

          }
        }

        if($connect->query("UPDATE orders SET total_amt = ".$total.",total_qty =".$itemqty." WHERE order_id = ".$order_id)){

        }
      }
    }
  }
}
unset($_SESSION['shipping']);
unset($_SESSION['cart']);
header("location:order-placed.php");

?>
