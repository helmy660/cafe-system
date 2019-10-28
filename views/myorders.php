<?php require_once('../config.php');
require_once(TEMPLATE_PATH . 'userHeader.php');

$user_id = $_SESSION['user_id'];

$userOrders = array();
?>

<div class="container-fluid     ">
    <div style="padding: 3%">
        <h1 style="text-align: center">My Orders</h1>
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
            </form>
        </div>
    </div>


    <hr>
    <!-- Users Table  -->
    <?php 
    if (isset($_POST['submit'])) {
        // echo $_POST['start'];
        // echo $_POST['end'];

        $startDate =  $_POST['start'];
        $endDate =  $_POST['end'];
        // echo "here  ";var_dump($userOrders);
        $query = "SELECT o.* FROM orders o WHERE o.user_id = $user_id AND o.date BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59' ORDER BY o.date DESC";
        $userOrders = DBModel::read($query);
        // var_dump($userOrders);
    } else {
        $userOrders = DBModel::read("SELECT orders.* FROM orders WHERE orders.user_id = $user_id ORDER BY orders.date DESC");
        // $deleteOrders = Products::read("SELECT o.* FROM orders o WHERE o.state = ' Processing '");
        // $inDeliveryOrders = Products::read("SELECT o.* FROM orders o WHERE o.state = ' Delivery '");
    };
    ?>
    <div id="reloadDate" style="width: 80%; margin: auto; padding-top: 2%;">


        <table class="table table-striped table-info " style="text-align:center">
            <thead>
                <tr>
                    <th scope="col" class="Date">Order Date</th>
                    <th scope="col" class="Date">Status</th>
                    <th scope="col" class="Date">Total</th>
                    <th scope="col" class="Date">Action</th>
                </tr>
            </thead>

            <!-- Get User Orders Data  -->
            <tbody>
                <?php 
                if (isset($userOrders)) {

                    foreach ($userOrders as $uorder) {  ?>


                <tr class="header accordion-toggle" data-toggle="collapse" data-target="#demo5<?php echo $uorder['id']; ?>">
                    <td scope="row"><?php echo $uorder['date']; ?></td>

                    <?php if ($uorder['state'] == "Processing") { ?>
                    <td class="btn-warning"><?php echo $uorder['state']; ?></td>
                    <?php 
                } else if ($uorder['state'] == "Delivery") { ?>
                    <td class="btn-success"><?php echo $uorder['state']; ?></td>
                    <?php 
                } else if ($uorder['state'] == "Done") { ?>
                    <td class="btn-secondary"><?php echo $uorder['state']; ?></td>
                    <?php 
                } ?>

                    <td><?php echo $uorder['amount']; ?> .EGP</td>

                    <?php if ($uorder['state'] == "Processing") { ?>
                    <form action="POST">
                        <td> <a id="<?php echo $uorder['id']; ?>" href="delete.php?id=<?php echo $uorder['id']; ?>&user=<?php echo $uorder['user_id']; ?>" name="button" class="btn btn-danger btnDelete">Cancel Order</a> </td>
                    </form>
                </tr>
                <?php 
            } else { ?>
                <td> - </td>
                </tr>
                <?php 
            } ?>
                <!-- show order -->
                <tr class="hiddenRow">
                    <td colspan="4">
                        <div class="accordian-body collapse" id="demo5<?php echo $uorder['id']; ?>">
                            <div class="container-fluid">
                                <div class="row">
                                    <?php 
                                    $orderItems = DBModel::read("SELECT order_product.*, products.* FROM order_product, products WHERE order_product.product_id = products.id and order_product.order_id =" . $uorder['id']);

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
        }
        ?>

                <!-- end get user data -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#dateFilter').click(function() {
                $('#reloadDate').load('myorders.php #reloadDate');
            });

            $.ajaxSetup({
                cache: false
            });

            $('.btnDelete').click(function() {
                if (confirm("Are you sure you want Cancel this order ?")) {
                    var id = $(this).attr('id');
                    // var data = 'id=' + id;
                    var parent = $(this).parent().parent();
                    console.log("id= " + id);
                    $.ajax({
                        type: "POST",
                        url: "delete.php",
                        data: "?id=" + id,
                        cache: false,
                        success: function() {
                            parent.fadeOut('slow', function() {
                                $(this).remove();
                            });
                        }
                    });
                }

            });
        });


        $('.accordian-body').on('show.bs.collapse', function() {
            $(this).closest("table")
                .find(".collapse.in")
                .not(this)
                .collapse('toggle')
        })
    </script>
    <footer>

    </footer>

    </body>

    </html> 