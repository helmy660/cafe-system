<?php require_once('../config.php');
require_once(TEMPLATE_PATH . 'header.php');

$admin = $_SESSION['admin'];
?>
<div class="container-fluid">
    <div style="padding: 3%">
        <h1 style="text-align: center">Orders</h1>
    </div>
    <div id="orders">
        <?php 
        $orders = DBModel::read("SELECT orders.*, users.name, users.ext, users.room FROM orders, users WHERE users.id = orders.user_id ORDER BY orders.state DESC");
        $inProcessOrders = Products::read("SELECT o.* FROM orders o WHERE o.state = 'Processing'");
        $inDeliveryOrders = Products::read("SELECT o.* FROM orders o WHERE o.state = 'Delivery'");
        ?>
        <!-- Users Table  -->
        <?php if (isset($orders)) {
            foreach ($orders as $order) {
                if ($order['state'] == "Processing" || $order['state'] == "Delivery") { ?>
        <div id="scores" style="width: 80%; margin: auto">
            <table class="table table-striped table-success ">
                <thead>
                    <tr>
                        <th scope="col">Order Date</th>
                        <th scope="col">Name</th>
                        <th scope="col">Room</th>
                        <th scope="col">Ext.</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="load">
                    <tr>
                        <td scope="row" class="Date"><?php echo $order['date']; ?></td>
                        <td class="Date"><?php echo $order['name']; ?></td>
                        <td class="Date"><?php echo $order['room']; ?></td>
                        <td class="Date"><?php echo $order['ext']; ?></td>
                        <?php if ($order['state'] == "Delivery") { ?>
                        <td class="Date btn-success" id="deliver" style="text-align:center"><?php echo $order['state']; ?></td>

                        <?php 
                    } else if ($order['state'] == "Processing") { ?>
                        <td class="Date btn-danger" id="processing" style="text-align:center"><?php echo $order['state']; ?></td>

                        <?php 
                    } ?>
                    </tr>

                    <tr style="-webkit-align-content: center;">
                        <th colspan="4">
                            <div class="container-fluid">
                                <div class="row">
                                    
                                    <?php 
                                            $orderItems = DBModel::read("SELECT order_product.*, products.* FROM order_product, products WHERE order_product.product_id = products.id and order_product.order_id =" . $order['id']);
                                  
                                            if (isset($orderItems)) {
                                        foreach ($orderItems as $item) {
                                             ?>

                                    <div class="card col-sm-2 product-card">
                                    <?php if($item['product_picture']){?>
                                        <img class="card-img-top buy-pic" src="<?php echo ($item['product_picture']); ?>" alt="Card image cap" />
                                        <?php } else {?>
                                        <img src="https://www.portugalbusinessontheway.com/wp-content/uploads/2019/02/SABORES-DAS-QUINAS-01.jpg" width="150" height="150">
                                          <?php } ?>

                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $item['product_name']; ?></h5>
                                            <p class="card-text"><?php echo $item['price']; ?> . EGP</p>
                                            <p class="card-text">Quantity : <?php echo $item['quantity']; ?></p>
                                        </div>
                                    </div>
                                    <?php

                                
                            } ?>
                        </th>

                        <th> 
                            <div class="col-sm-3">
                            <h3>Total  <?php echo ($item['quantity'] * $item['price']); ?></h3>
                        </div>
                        </th>
                        <?php } ?>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <?php

}
}
} else { ?>
    <div>
        <h1>There Is No Orders Yet </h1>
    </div>
    <?php 
} ?>

    <!--
                

                    

                    <div class="card col-sm-3 product-card" style="width: 18rem;">
                        <img class="card-img-top buy-pic" src="https://canolaeatwell.com/wp-content/uploads/2017/04/Slow-Cooker-Chicken-Shawarma-With-Tomato-Cucumber-Relish-1_WEB-1024x683.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">shawarma</h5>
                            <p class="card-text">10 .EGP</p>
                            <div class="order-btn">
                                <input type="submit" value="Order" class="btn btn-info">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

 -->

</div>
<script>
    $(document).ready(function() {

        setInterval(function() {
            $('#orders').load('AdminHome.php #orders');
        }, 3000)
        $.ajaxSetup({
            cache: false
        });
    });
</script>
<footer>
    <script>
        setInterval(function() {

            let promise = new Promise(function(resolve, reject) {

                return new Promise <?php 
                                    foreach ($inProcessOrders as $order) {
                                        $o = new Orders();
                                        $o->id = (int)$order['id'];
                                        $o->user_id = (int)$order['user_id'];
                                        $o->date = $order['date'];
                                        $o->note = $order['notes'];
                                        $o->amount = (int)$order['amount'];
                                        $o->state = 'Delivery';
                                        $o->save();
                                    }
                                    ?>
            });
            promise.then(function() {
                setTimeout(() => {
                    <?php 
                    foreach ($inDeliveryOrders as $order) {
                        $do = new Orders();
                        $do->id = (int)$order['id'];
                        $do->user_id = (int)$order['user_id'];
                        $do->date = $order['date'];
                        $do->note = $order['notes'];
                        $do->amount = (int)$order['amount'];
                        $do->state = 'Done';
                         $do->save();
                    }
                    ?>
                }, 100000);

            });

        }, 60000);
    </script>
</footer>
</body>

</html> 