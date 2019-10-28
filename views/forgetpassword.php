<?php
require_once('../config.php');
require_once('../lib/DBModel.php');
require '../vendor/autoload.php';


if (isset($_POST['email'])) {
        $email = $_POST['email'];
        echo $email;
        $result = DBModel::read("SELECT u.id FROM users u WHERE u.email='". $email ."' ");
        if ($result > 0) {

            $token = "poiuztrewqasdfghjklmnbvcxy1234567890";
            $token = str_shuffle($token);
            $token = substr($token, 0, 10);

	        $dbh->query("UPDATE users SET token='$token',
                      tokenExpire=DATE_ADD(NOW(), INTERVAL 20 MINUTE)
                      WHERE email='$email'
            ");
            $mail = new PHPMailer\PHPMailer\PHPMailer();
	        $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = TRUE;
            $mail->Username = "ahmedmagdy2016@gmail.com";
            $mail->Password = "yxsrsiuzpaewwbhb";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->From = "ahmedmagdy2016@gmail.com";
            $mail->FromName = "ITI Cafeteria";
            $mail->Subject = "Reset Password";
            $mail->addAddress($email);
	        $mail->isHTML(true);
	        $mail->Body = "
	            Hi,<br><br>

	            In order to reset your password, please click on the link below:<br>
                <a href='". HOST_NAME ."/views/resetpassword.php?email=$email&token=$token'>
                ". HOST_NAME ."views/resetpassword.php?email=$email&token=$token
                </a><br><br>

	            Kind Regards,<br>
	            ITI
	        ";

	        if ($mail->send())
    	        echo "An Email has been sent to your email, Please Check your Inbox";
    	    else
    	        echo 'Something Wrong Just Happened! Please try again!';
        } else
            echo 'Please Check Your Inputs!';
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget Password</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/main.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/custom.sass">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/_variables.scss">
</head>

<body>
    <div class="col-md-4 col-md-offset-4 login">
        <form action="./forgetpassword.php" method="POST">
            <div class=" text-center mb-4">
                <h1 class="h3 mb-3 font-weight-normal">Email</h1>
            </div>
            <div class="form-label-group login-label">
                <input class="form-control" type="email" name="email" placeholder="Email-Address">
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="forget">Send Email</button>
        </form>

    </div>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript">
    var email = $("#email");

    $(document).ready(function() {
        $('.btn-primary').on('click', function() {
            if (email.val() != "") {
                email.css('border', '1px solid green');
            } else
                email.css('border', '1px solid red');
        });
    });
    </script>
</body>

</html>