<?php  require_once('../config.php'); 
require_once(TEMPLATE_PATH . 'userHeader.php'); 

$user_id = $_SESSION['user_id'];

$products = DBModel::read("SELECT p.* FROM products p WHERE p.availability = 1",null);
$rooms = DBModel::read("SELECT DISTINCT u.room FROM users u WHERE u.admin = 0",null);
$latestOrder = DBModel::read("SELECT DISTINCT o.* FROM orders o WHERE o.user_id = $user_id order by o.date DESC LIMIT 1",PDO::FETCH_CLASS,'Orders');

$orderProducts = DBModel::read("SELECT p.product_name, p.product_picture FROM products p WHERE p.id in (SELECT id FROM order_product WHERE order_id = $latestOrder->id)",null);

?>

<div class="container-fluid">
    <div class="col-sm-4" style="float:left">
    <div class="row">
        <form action="addManualOrder.php" method="GET">
            <h1 class="modal-header"> Order</h1>

            <!-- OrderItems  -->
            <div id="orderItemContainer">
           
            </div>

            </div>

            <!-- End orders -->
            <hr />
            <!-- start notes -->
            <div class="form-group shadow-textarea">
                <label for="exampleFormControlTextarea6">Notes</label>
                <textarea name="note" class="form-control z-depth-1" id="exampleFormControlTextarea6" rows="3" placeholder="Write your notes ..."></textarea>
            </div>

            <!-- end notes -->

            <!-- start room number -->
            <div class="form-group row">
                <label for="room" class="col-md-3 col-form-label text-md-center">Room</label>
                <div class="col-md-8">

                    <select name="room" style="width: 100%;padding-top:2%;margin-top:2%" required>

                        <option selected disabled>Select Room</option>
                        <?php if(isset($rooms)) {
                            foreach ($rooms as $room) {?>

                                <option value="<?php echo $room['room']; ?>"><?php echo $room['room'];?></option>

                        <?php }}?>
                            
                    </select>
                    <input type="hidden" name="user" value="<?php echo $user_id;?>" />            
                </div>
            </div>
            <!-- End room number -->
            <hr>
            <!-- End Of Form -->
            <div class="total-cost">
                <h2 id="orderTotalAmount"> Total = <span>0<span> </h2>
                <input id="total_amount" type="hidden" name="total_amount" value="0"/>
                <input id="item_count" type="hidden" name="itemCount" value="0"/>
                
            </div>
            <!-- Form Button -->
            <div class="order-btn">
                <input type="submit" value="Confirm" name="confirm" class="btn btn-success">
            </div>
    
            </form>
        <!-- menu -->
        </div>
        <div class="col-sm-7 " style="float:left">
             <div>
              <h2><span>Latest Order</span></h2>
             </div>
              <div class="container">
                    <div class="row">
                    
                     <?php if($orderProducts) {
                        foreach ($orderProducts as $product) {?>
                        <div class="card col-sm-3 product-card" style="width: 18rem;">

                            

                            <?php if($product['product_picture']){?>
                                        <img class="card-img-top buy-pic" width="150" height="150" src="<?php echo ($product['product_picture']); ?>" alt="Card image cap" />
                                        <?php } else {?>
                                        <img src="https://www.portugalbusinessontheway.com/wp-content/uploads/2019/02/SABORES-DAS-QUINAS-01.jpg" width="150" height="150">
                             <?php } ?>





                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                            </div>
                        </div>
                        <?php } 
                    }else{
                        echo "<div>You don't have any Orders yet</div>";
                    } ?>
                    </div>
                </div>

                <hr />
                                
             <!-- products -->
                <div class="container" style="clear:both">
                    <div>
                      <h2><span>Available Products</span></h2>
                    </div>
             
                    <?php if(isset($products)) {
                        foreach ($products as $product) {?>
                        <div class="card col-sm-3 product-card" style="float:left">
                            
                            <?php if($product['product_picture']){?>
                                        <img class="card-img-top buy-pic" width="150" height="150" src="<?php echo ($product['product_picture']); ?>" alt="Card image cap" />
                                        <?php } else {?>
                                        <img class="card-img-top buy-pic" src="https://www.portugalbusinessontheway.com/wp-content/uploads/2019/02/SABORES-DAS-QUINAS-01.jpg" width="150" height="150">
                            <?php } ?>

                            
                            <div class="card-body">
                                <h5 id="name" class="card-title"><?php echo $product['product_name']; ?></h5>
                                <p id="price" class="card-text"><?php echo $product['price']; ?><span> .EGP</span></p>
                                <input id="pid" type="hidden" value="<?php echo $product['id']; ?>" />
                                <div class="order-btn">
                                    <input type="button" value="Order" class="orderTheItem btn btn-info" />
                                </div>
                            </div>
                        </div>

                 <?php } } ?>
                </div>

        </div>
    </div>
</div>
<script src="../js/plugin.js" ></script>
</body>

</html> 