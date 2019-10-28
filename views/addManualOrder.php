<?php require_once('../config.php');
session_start();
$admin = $_SESSION['admin'];

if(isset($_GET['confirm']) && $_GET['itemCount'] > 0){

    $order = new Orders();
    $order->user_id = $_GET["user"];
    $order->amount = $_GET["total_amount"];
    $order->notes = $_GET["note"];
    $order->state = "Processing";
    $order->date = date("Y-m-d H:i:s");

    $orderId = $order->save();
    if($orderId){
    
        $flag = 0;
        $itemCount = $_GET['itemCount'];
        for($i=1;;$i++){
            if($flag == $itemCount)
                break;
        
            if(isset($_GET["quantity$i"])){
                $orderItem = new OrderItems();
                $orderItem->order_id = $orderId;
                $orderItem->product_id = (int)$_GET["productId$i"];
                $orderItem->quantity = $_GET["quantity$i"];
                $orderItem->product_price = $_GET["item_total_amount$i"];

                $orderItem->save();
                $flag++;
            }
        }
    }

   
}

if($admin == 1){ 
    header("Location: manual.php");

}else{
    header("Location: userHome.php");
}




?>