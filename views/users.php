<?php 
require_once('../config.php');
require_once('../templates/header.php'); 

$admin = $_SESSION['admin'];

// Delete 
if(isset($_GET["id"])){
    $user = new Users();
    $user->id=$_GET["id"];
    $user->delete();
    header('Location:users.php');
}

$users = DBModel::read("SELECT * FROM users",null);


$nr =  sizeof($users);
$items_per_page = 3;
$total_no_of_pages = ceil($nr / $items_per_page);
$page = 1;
if(isset($_GET['page']))
    $page = $_GET['page'];

$offset = ($page-1) * $items_per_page;

?>
<div class="container-fluid     ">
    <div style="padding: 3%">
        <h1 style="text-align: center"> Users</h1>
        <form action="adduser.php">
        <button type="submit" class="btn btn-success add-btn" >Add User</button>
        </form>
    </div>
    
    <div style="width: 80%; margin: auto">
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Room</th>
                    <th scope="col">Image</th>
                    <th scope="col">EXT.</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>   
            <?php if(count($users)) {
                    //$items_per_page + $offset
                    for($i= $offset ; $i<$items_per_page + $offset; $i++){   if($users[$i]){ ?>
                        <tr>
                            <th scope="row"><?php echo $users[$i]['name'];?></th>
                            <td><?php echo $users[$i]['room'];?></td>
                            <td>
                                <div class="inset">
                                    
                                    <?php if($users[$i]['picture']){?>
                                        <img src=<?php echo $users[$i]['picture'];?>>
                                    <?php } else {?>
                                        <img src="http://rs775.pbsrc.com/albums/yy35/PhoenyxStar/link-1.jpg~c200">
                                    <?php } ?>

                                </div>
                            </td>
                            <td><?php echo $users[$i]['ext'];?></td>
                            <td>
                                <a class="btn btn-info" href="/views/edituser.php?id=<?php echo $users[$i]['id']?>">Edit</a>
                                <a class="btn btn-info" href="/views/users.php?id=<?php echo $users[$i]['id']?>">Delete</a>
                            </td>
                        </tr>
                        <?php }}}?>
            </tbody>
        </table>
    </div>


    <div class='pagination'>
        <a href="users.php?page=<?php echo ($page-1);?>" style ="<?php if($page == 1) echo 'pointer-events: none'; else echo '""'; ?>" > < </a>
        <span> <?php echo "&nbsp" .($page) . "&nbsp";?> </span>
        <a href="users.php?page=<?php echo ($page+1);?>" style ="<?php if($page == $total_no_of_pages) echo 'pointer-events: none'; else echo '""'; ?>" > > </a> 
    </div>

</div>

</body>

</html> 