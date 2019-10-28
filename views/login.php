<?php

if (isset($_POST['logIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = DBModel::read("SELECT u.* FROM users u WHERE u.email ='". $email ."'");

    if(password_verify($password, $result[0]['password'])){
            if ($result) {

            session_start();
            $_SESSION['user_id'] = $result[0]['id'];
            $_SESSION['admin'] = $result[0]['admin'];

            if($result[0]['admin'] == 1){

                header("Location: /views/AdminHome.php");

            }
            else {

                header("Location: /views/userHome.php");

            }
        }
    }
    else {
        echo 'Email or Password is invalid ';
    }

}

//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $result = DBModel::read("SELECT u.* FROM users u WHERE u.email ='$email' AND u.password ='$password'");

//     if ($result) {

//         session_start();
//         $_SESSION['user_id'] = $result[0]['id'];
//         $_SESSION['admin'] = $result[0]['admin'];

//         if($result[0]['admin'] == 1){

//             header("Location: /views/AdminHome.php");

//         }
//         else {

//             header("Location: /views/userHome.php");

//         }
//     }
//     else {
//         echo 'Email or Password is invalid ';
//     }
// }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/main.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/custom.sass">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/_variables.scss">
    <!-- Latest compiled and minified CSS -->

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->

    <!-- jQuery library -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->

    <!-- Popper JS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->

    <!-- Latest compiled JavaScript -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->

</head>

<body>
    <div>
        <h1 class="bumpy">Welcome! To ITI Cafeteria</h1>
    </div>
    <div class="col-md-4 col-md-offset-4 login">
        <form class="form-signin login-form" method="POST">
            <div class="text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal">Please LogIn</h1>
            </div>
            <div class="form-label-group login-label">
                <input class="form-control" type="email" name="email" placeholder="Email-Address">
            </div>
            <div class="form-label-group login-label">
                <input class="form-control" type="password" name="password" placeholder="Password">
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="logIn">Log In</button>
        </form>
        <a href="/views/forgetpassword.php">Forget Password?</a>
    </div>
</body>

</html>