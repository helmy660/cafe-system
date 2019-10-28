<?php 

Class Orders extends DBModel {

    public $id;
    public $user_id;
    public $state;
    public $notes;
    public $date;
    public $amount;

    public $tableName = 'orders';

    public $dbFields  = array(
        'user_id',
        'state',
        'notes',
        'date',
        'amount'
    );
}

?>