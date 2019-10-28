<?php 

Class Products extends DBModel {

    public $id;
    public $product_name;
    public $price;
    public $category_id;
    public $availability=1;
    public $product_picture;

    public $tableName = 'products';

    public $dbFields  = array(
        'product_name',
        'price',
        'category_id',
        'availability',
        'product_picture'
    );
}

?>