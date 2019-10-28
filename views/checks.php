<?php require_once('../config.php');
require_once('../templates/header.php');

session_start();
$admin = $_SESSION['admin'];

$userOrders = array();
$users = DBModel::read("SELECT u.* FROM users u WHERE u.admin = 0", null);
?>
<form method="post">
    <div class="container-fluid     ">
        <div style="padding: 3%">
            <h1 style="text-align: center">Checks</h1>
        </div>

        <!-- Start And End Dates of Orders -->

        <div class="container-fluid">
            <div class="row">
                <form method="POST" class="cform">
                    <div class="col-md-auto">
                        <label class="labelDate">Start Date</label>
                        <input type="date" name="start" id="start" value="<?php echo $_POST['start']; ?>" class="Date">
                    </div>
                    <div class="col-md-auto">
                        <label class="labelDate">End Date</label>
                        <input type="date" name="end" id="end" value="<?php echo $_POST['end']; ?>" class="Date">
                    </div>
                    <div class="col-md-auto">
                        <input type="submit" value="Filter" class="btn btn-info" id="dateFilter" name="submit">
                    </div>
               
            </div>
        </div>

        <!-- users dropdown list -->

    </div>
    <div class="col-sm-7 " style="float:left">
        <div class="add-to-user">
            <div class="form-group row">
                <label for="user" class="col-md-3 col-form-label text-md-center">
                    <h3>Users</h3>
                </label>
                <div class="col-md-8">
                    <select name="user" style="width: 100%;padding-top:2%;margin-top:2%">
                        <option value="Select User" selected disabled>
                            <?php 
                            // if (isset($_POST['submit'])) {
                            //     $userSelected = $_POST['user'];
                            //     echo $userSelected;
                            // }
                            ?>
                        </option>
                        <?php if (isset($users)) {
                            foreach ($users as $user) { ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
                        <?php 
                    }
                } ?>
                    </select>
                </div>
            </div>
        </div>
        <hr />
    </div>
    </form>
    <!-- Users Table  -->

    <div style="width: 80%; margin: auto">
        <table class="table table-striped table-success " id="relTable">
            <thead>
                <tr>
                    <th scope="col" style="background-color:#FAF0EE">Name</th>
                    <th scope="col" style="background-color:#FAF0EE">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(isset($_POST['user']))
                 $users = DBModel::read("SELECT u.* FROM users u WHERE u.id =". $_POST['user']);
                              
                if (isset($users)) {
                    foreach ($users as $user) { ?>
                <tr class="header accordion-toggle" data-toggle="collapse" data-target="#demo5<?php echo $user['id']; ?>">
                    <td class="Date"> <?php echo $user['name'];
                                        $user_id = $user['id']; ?> </td>
                    <td class="Date"> <?php $amount = DBModel::read("SELECT SUM(o.amount) FROM orders o WHERE o.user_id = $user_id", null);
                                        if (isset($amount)) {
                                            foreach ($amount as $element) {
                                                echo $element[0];
                                            }
                                        } ?>
                    </td>
                    </th>
                </tr>
                <tr class="hiddenRow">
            <tbody class="accordian-body collapse" id="demo5<?php echo $user['id']; ?>">

                <!-- get data orders for user  -->
                <?php 
                $uid = (int)$user['id'];
                if (isset($_POST['submit'])) {
                    $startDate =  $_POST['start'];
                    $endDate =  $_POST['end'];
                    $query = "SELECT o.* FROM orders o WHERE o.user_id = $uid AND o.date BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59' ORDER BY o.date DESC";
                    $userOrders = DBModel::read($query);
                } else {
                    $userOrders = DBModel::read("SELECT orders.* FROM orders WHERE orders.user_id = $uid ORDER BY orders.date DESC");
                };
                ?>

                <tr>
                    <th scope="col" style="background-color:antiquewhite">Order Date</th>
                    <th scope="col" style="background-color:antiquewhite">Amount</th>
                </tr>

                <!-- show orders -->

                <?php 
                if (isset($userOrders)) {
                    foreach ($userOrders as $usrorder) { ?>

                <tr data-toggle="collapse" data-target="#demo5<?php echo $usrorder['id']; ?>">

                    <td style="background-color:antiquewhite"><?php echo $usrorder['date']; ?></td>
                    <td style="background-color:antiquewhite"><?php echo $usrorder['amount'] . " .EGP"; ?></td>
                </tr>
                <!-- show order -->
                <tr class="hiddenRow">
                    <td colspan="4">
                        <div class="accordian-body collapse" id="demo5<?php echo $usrorder['id']; ?>">
                            <div class="container-fluid">
                                <div class="row">
                                    <?php 
                                    $orderItems = DBModel::read("SELECT order_product.*, products.* FROM order_product, products WHERE order_product.product_id = products.id and order_product.order_id =" . $usrorder['id']);

                                    if (isset($orderItems)) {
                                        foreach ($orderItems as $item) {
                                            ?>
                                    <div class="card col-sm-2 product-card">
                                        <img class="card-img-top buy-pic" src="<?php echo "data:image/jpeg;base64," . base64_encode($item['product_picture']); ?>" alt="Card image cap" />
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $item['product_name']; ?></h5>
                                            <p class="card-text"><?php echo $item['price']; ?> . EGP</p>
                                            <p class="card-text">Quantity : <?php echo $item['quantity']; ?></p>
                                        </div>
                                    </div>
                                    <!-- </t    d> -->
                                    <?php

                                } ?>
                                </div>
                            </div>
                        </div>
                    </td>


                    <?php 
                } ?>
                </tr>

                <!-- </div> -->

                <?php 
            }
        } else { ?>

                <tr>
                    <td colspan="2" class="Date">No Orders Yet !!</td>
                </tr>
                <?php 
            }
            ?>

            </tbody>
            </tr>

            <?php 
        }
    }
    ?>
            </tbody>
        </table>
    </div>
    <script>

$(document).ready(function() {
            $('#dateFilter').click(function() {
                $('#relTable').load('checks.php #relTable');
            });

            $.ajaxSetup({
                cache: false
            });


        $('.accordian-body').on('show.bs.collapse', function() {
            $(this).closest("table")
                .find(".collapse.in")
                .not(this)
                .collapse('toggle')
        })
    </script>
    </body>
</form>

</html> 