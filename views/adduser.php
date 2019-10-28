<?php 
require_once('../config.php');
require_once('../templates/header.php'); 


if(isset($_POST["uSubmit"]) && isset($_POST["full-name"]) && isset($_POST["email-address"]) && isset($_POST["password"]) && isset($_POST["confirm-password"]) && isset($_POST["roomNumber"]) && isset($_POST["permanent-address"])  ){
    $uMail=$_POST["email-address"];
    $userMail =  DBModel::read("SELECT * FROM users WHERE email='$uMail'",null);
   if($_POST['password']===$_POST['confirm-password'] && $userMail==null)
   {
    $newUser = new Users();
    $newUser->name=trim($_POST['full-name']);
    $newUser->password=password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $newUser->email=trim($_POST["email-address"]);
    $newUser->room=$_POST["roomNumber"];
    $newUser->ext=$_POST["permanent-address"];

    if(is_uploaded_file($_FILES['profile_pics']['tmp_name'])){
        $im='data:image/jpeg;base64,'.base64_encode(file_get_contents($_FILES['profile_pics']['tmp_name']));
    }
    
    $newUser->picture=$im;
    $newUser->save();
    $check_password=1;
    $check_mail=1;
    $population_flag=0;
    header('Location:users.php');
   }
   else {
       $name=trim($_POST['full-name']);
       $password=trim($_POST['password']);
       $confirm_password=$_POST['confirm-password'];
       $email=trim($_POST["email-address"]);
       $room=$_POST["roomNumber"];
       $ext=$_POST["permanent-address"];
       $population_flag=1;
       if ($_POST['password']!==$_POST['confirm-password'])
          {$check_password=0;}
        if ($userMail!=null)
          {$check_mail=0;}   
   }
}
?>

<div class="container adduser">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
        </div>
    <div class="modal-body">
        <div class="modal-body">
                    <form name="my-form" onsubmit="" action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="full_name" class="col-md-4 col-form-label text-md-right">Full Name</label>
                            <div class="col-md-6">
                                <input type="text" id="full_name" class="form-control" name="full-name" value="<?php if($population_flag)echo $name;?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" id="email_address" class="form-control" name="email-address" value="<?php if($population_flag)echo $email;?>" required>
                                <?php 
                                        if (isset($check_mail)){
                                        if ($check_mail==0) {?>  
                                                <span><b>This mail is already existed</b></span>
                                     <?php }} ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password" class="form-control" name="password" value="<?php if($population_flag)echo $password;?>" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password" class="form-control" name="confirm-password" value="<?php if($population_flag)echo $confirm_password;?>" required>
                                    <?php 
                                        if (isset($check_password)){
                                        if ($check_password==0) {?>  
                                                <span><b>Not Matched</b></span>
                                     <?php }} ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="room_number" class="col-md-4 col-form-label text-md-right">Room Number</label>
                            <div class="col-md-6">
                                <input type="number" id="room_number" class="form-control" name="roomNumber" value="<?php if($population_flag)echo $room;?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ext" class="col-md-4 col-form-label text-md-right">EXT.</label>
                            <div class="col-md-6">
                                <input type="number" id="ext" class="form-control" name="permanent-address" value="<?php if($population_flag)echo $ext;?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="profile_pics" class="col-md-4 col-form-label text-md-right">User Picture
                            <div class="col-md-6">
                                <input type="file" name="profile_pics" class="btn" accept="image/*">
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-4">
                            <button type="button" class="btn btn-warning">Reset</button>
                            <button type="submit" class="btn btn-success" name="uSubmit">Add User</button>
                            <a class="btn btn-info" href="/views/users.php">Back</a>
                        </div>
                    </form>
        </div>
    </div>
    </div>
</div>