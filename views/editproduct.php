<?php 
require_once('../config.php');
require_once('../templates/header.php'); 

$admin = $_SESSION['admin'];

$categories = DBModel::read("SELECT * FROM category",null);

// Getting this product with id sent in query string to populate the form with already existed data
if(isset($_GET["id"])){
    $id=$_GET["id"];
    $product =  DBModel::read("SELECT * FROM products WHERE id= $id",PDO::FETCH_CLASS,'Products');
    $cat_id=$product->category_id;
}

if(isset($_POST["pSubmit"]) && isset($_POST["pName"]) && isset($_POST["pPrice"]) && isset($_POST["pCatID"]) ){
    $newProduct = new Products();
    $newProduct->id=$product->id;
    $newProduct->product_name=$_POST['pName'];
    $newProduct->price=$_POST['pPrice'];
    $newProduct->category_id=$_POST['pCatID'];
    $newProduct->availability=$product->availability;

    //if(($_FILES['product_pics']['tmp_name'])!==null){
    if(is_uploaded_file($_FILES['product_pics']['tmp_name'])){
        $im='data:image/jpeg;base64,'.base64_encode(file_get_contents($_FILES['product_pics']['tmp_name']));
        $newProduct->product_picture=$im;
    }
    else{
        //var_dump($product->product_picture);
        $newProduct->product_picture=$product->product_picture;
    }
    
    $newProduct->save();
     header('Location:products.php');
}

?>

<div class="container addProduct">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
        </div>
        <div class="modal-body">
            <form name="my-form" onsubmit="" action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="product_name" class="col-md-4 col-form-label text-md-right">Product Name</label>
                                <div class="col-md-6">
                                    <input type="text" id="product_name" class="form-control" name="pName" value="<?php echo $product->product_name?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="room_number" class="col-md-4 col-form-label text-md-right">Price </label>
                                <div class="col-md-4">
                                    <input type="number" id="room_number" class="form-control" name="pPrice" value="<?php echo $product->price?>" required>
                                </div>
                                <label for="room_number" class="col-md-2 col-form-label text-md-right">EGP </label>
                            </div>

                            <div class="form-group row">
                                <label for="category" class="col-md-4 col-form-label text-md-right">Category</label>
                                <div class="col-md-6">
                                    <select id="category" list="categories" class="form-control" name="pCatID"  style="width: 100%;padding-top:2%;margin-top:2%" required>
                                    <!-- <option selected>Select Category</option> -->
                                    
                                        <?php if(isset($categories)) {
                                            foreach ($categories as $category) {?>
                                            <option value="<?php echo $category['id'];?>" <?php if($category['id']==$cat_id) echo "selected";?>  ><?php echo $category['category_name'];?></option>
                                        <?php }}?>
                                    </select>

                                </div>
                            </div>
                    </div>

                    <div class="form-group row">
                        <label for="product_pics" class="col-md-4 col-form-label text-md-right">Product Picture
                            <div class="col-md-6">
                                <input type="file" name="product_pics" class="btn"> 
                            </div>
                    </div>

                    <div class="col-md-6 offset-md-4">
                        <button type="button" class="btn btn-warning">Reset</button>
                        <button type="submit" class="btn btn-success" name="pSubmit">Submit Changes</button>
                        <a class="btn btn-info" href="/views/products.php">Back</a>
                    </div>
                </div>
                </form>

</div>
</div>
</div>
</body>

</html> 