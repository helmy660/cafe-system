<?php 
require_once('../config.php');
require_once('../templates/header.php'); 

$admin = $_SESSION['admin'];

if(isset($_POST["submitCategory"])){
    var_dump ($_POST["cat-name"]);
    $newCategory=new Categories();
    $newCategory->category_name=$_POST["cat-name"];
    $newCategory->save();
     //header('Location:products.php');
}
$categories = DBModel::read("SELECT * FROM category",null);
?>

<div class="container addProduct">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
        </div>
        <div class="modal-body">
            <form name="my-form" onsubmit="" action="products.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="product_name" class="col-md-4 col-form-label text-md-right">Product Name</label>
                                <div class="col-md-6">
                                    <input type="text" id="product_name" class="form-control" name="pName" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="room_number" class="col-md-4 col-form-label text-md-right">Price </label>
                                <div class="col-md-4">
                                    <input type="number" id="room_number" class="form-control" name="pPrice" required>
                                </div>
                                <label for="room_number" class="col-md-2 col-form-label text-md-right">EGP </label>
                            </div>

                            <div class="form-group row">
                                <label for="category" class="col-md-4 col-form-label text-md-right">Category</label>
                                <div class="col-md-6">
                                    <select id="category" list="categories" class="form-control" name="pCatID" style="width: 100%;padding-top:2%;margin-top:2%" required>
                                    <option disabled selected>Select Category</option>
                                        <?php if(isset($categories)) {
                                            foreach ($categories as $category) {?>
                                            <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name'];?></option>
                                        <?php }}?>
                                    </select>
                                </div>
                                <!-- add category start  -->

                                <div>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#addModal">Add Category</button>
                                </div>
                                <!-- add category END  -->
                                
                            </div>

                   

                    <div class="form-group row">
                        <label for="product_pics" class="col-md-4 col-form-label text-md-right">Product Picture
                            <div class="col-md-6">
                                <input type="file" name="product_pics" class="btn"> 
                            </div>
                    </div>

                    <div class="col-md-6 offset-md-4">
                        <button type="button" class="btn btn-warning">Reset</button>
                        <button type="submit" class="btn btn-success" name="pSubmit">Add Product</button>
                        <a class="btn btn-info" href="/views/products.php">Back</a>
                    </div>
            </form>



        </div>
    </div>
</div>


<!-- modal for add category  -->

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="my-form" onsubmit="" action="" method="POST">
                    <div class="form-group row">
                        <label for="cat_name" class="col-md-4 col-form-label text-md-right">Category Name</label>
                        <div class="col-md-6">
                            <input type="text" id="cat_name" class="form-control" name="cat-name" required>
                            <button type="submit" class="btn btn-primary" name="submitCategory">ADD</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for add category  -->
</body>

</html> 