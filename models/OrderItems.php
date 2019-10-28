<?php 

Class OrderItems extends DBModel {

    public $order_id;
    public $product_id;
    public $quantity;
    public $product_price;
    
    public $tableName = 'order_product';

    public $dbFields  = array(
        'order_id',
        'product_id',
        'quantity',
        'product_price'
    );
}

?>