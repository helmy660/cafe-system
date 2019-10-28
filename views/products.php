<?php
require_once('../config.php');
require_once('../templates/header.php');
    


// Delete
if(isset($_GET["id"])){
    $product = new Products();
    $product->id=$_GET["id"];
    $product->delete();
    header('Location:products.php');
}

//returning from add product page
if(isset($_POST["pSubmit"]) && isset($_POST["pName"]) && isset($_POST["pPrice"]) && isset($_POST["pCatID"]) ){
    $newProduct = new Products();
    $newProduct->product_name=$_POST['pName'];
    $newProduct->price=$_POST['pPrice'];
    $newProduct->category_id=$_POST['pCatID'];


    if(is_uploaded_file($_FILES['product_pics']['tmp_name'])){
    $im='data:image/jpeg;base64,'.base64_encode(file_get_contents($_FILES['product_pics']['tmp_name']));
    }
    $newProduct->product_picture=$im;
    $newProduct->save();
     header('Location:products.php');
}

// Change availability
if(isset($_POST["availability"])){
    $av=(int)$_POST["availability"][0];
    $pID=(int)substr($_POST["availability"],1);
    $p=  DBModel::read("SELECT * FROM products WHERE id= $pID",PDO::FETCH_CLASS,'Products');
    $p->availability=$av;
    $p->save();
}

$categories = DBModel::read("SELECT * FROM category",null);
$products = DBModel::read("SELECT * FROM products",null);
$nr =  sizeof($products);
$items_per_page = 3;
$total_no_of_pages = ceil($nr / $items_per_page);
$page = 1;

if(isset($_GET['page']))
    $page = $_GET['page'];

$offset = ($page-1) * $items_per_page;


?>

<div class="container-fluid ">
    <div style="padding: 3%">
        <h1 style="text-align: center"> Products</h1>
        <form action="addproduct.php">
            <button type="submit" class="btn btn-success add-btn">Add Product</button>
        </form>
    </div>

    <!-- Users Table -->

    <div style="width: 80%; margin: auto">
        <table class="table table-striped table-dark ">
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($products)) {
                    for($i= $offset ; $i<$items_per_page + $offset; $i++){   if($products[$i]){ ?>
                        <tr>
                            <th scope="row"><?php echo $products[$i]['product_name']?></th>
                            <td><?php echo $products[$i]['price']?></td>
                            <td> 
                                <div class="product_inset">
                                <?php if($products[$i]['product_picture']){?>
                                    <img class="card-img-top buy-pic" width="150" height="150" src=<?php echo $products[$i]['product_picture'];?>>
                                    <?php } else {?>
                                        <img src="https://www.portugalbusinessontheway.com/wp-content/uploads/2019/02/SABORES-DAS-QUINAS-01.jpg" width="150" height="150">
                                    <?php } ?>
                                </div>
                            </td>
                            <td>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <form action="" method="POST">
                                        <select id="av" list="products" class="form-control" name="availability" style="width:40%" onchange="this.form.submit()" required >
                                                <option <?php if($products[$i]['availability']==1) echo "selected";?> value="1<?php echo $products[$i]['id'];?>">Available</option>
                                                <option <?php if($products[$i]['availability']==0) echo "selected";?> value="0<?php echo $products[$i]['id'];?>">Not Available</option>
                                        </select>
                                    </form>
                                </div>
                                <a class="btn btn-info" href="/views/editproduct.php?id=<?php echo $products[$i]['id']?>">Edit</a>
                                <a class="btn btn-info" href="/views/products.php?id=<?php echo $products[$i]['id']?>">Delete</a>
                                
                            </div> 
                            </td>
                        </tr>
                                         
                <?php }}}?>
            </tbody>
        </table>
    </div>

    
    <div class='pagination'>
        <a href="products.php?page=<?php echo ($page-1);?>" style ="<?php if($page == 1) echo 'pointer-events: none'; else echo '""'; ?>" > < </a>
        <span> <?php echo "&nbsp" .($page) . "&nbsp";?> </span>
        <a href="products.php?page=<?php echo ($page+1);?>" style ="<?php if($page == $total_no_of_pages) echo 'pointer-events: none'; else echo '""'; ?>" > > </a> 
    </div>
    
</div>
</div>
</body>

</html>