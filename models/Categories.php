<?php 

Class Categories extends DBModel {

    public $id;
    public $name;
    
    public $tableName = 'category';

    public $dbFields  = array(
        'category_name'
    );
}

?>