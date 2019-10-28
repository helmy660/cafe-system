<?php
    require_once('../config.php');
    require_once('../lib/DBModel.php');
    require '../vendor/autoload.php';

    // $hash = '$2y$10$5zzFGhXxew49E4s5Pn/sJuIsPxfUW00stVHQo/Kp00KSChGZBs9JC';

    // if (password_verify('o1trhya@ds', $hash)) {
    //     echo 'Password is valid!';
    // } else {
    //     echo 'Invalid password.';
    // }

	if (isset($_GET['email']) && isset($_GET['token'])) {
        $email = $_GET['email'];
        $token = $_GET['token'];
		$result = DBModel::read("SELECT id FROM users WHERE
			email='$email' AND token='$token' AND token<>'' AND tokenExpire > NOW()
		");

		if ($result > 0) {
            $token = "qwertyuiopasdfghjklzxcvbnm1234567890:@`";
			$token = str_shuffle($token);
            $token = substr($token, 0, 10);
            $newPassword = $token;
            // print"$newPassword\n\n\n";
            $newPasswordEncrypted = password_hash($newPassword, PASSWORD_BCRYPT);
            // echo"$newPasswordEncrypted";
			$dbh->query("UPDATE users SET tokenExpire='0000-00-00 00:00:00', token='', password = '$newPasswordEncrypted'
				WHERE email='". $email ."'
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
	        $mail->Body = "This is your new password for iti cafeteria :    ".$newPassword;

            if ($mail->send()){
                echo "Your New Password Sent To Your Email, Please Check your Inbox<br><a href='/index.php'>Click Here To Log In</a>";
            }
            else {
                echo "Mail Send Error";
            }
		} else
			header('Location: /');
	 } else {
		header('Location: /');
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/main.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/custom.sass">
    <link rel="stylesheet" type="text/css" media="screen" href="../styles/_variables.scss">
</head>

<body>

</body>

</html>