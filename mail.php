<?php
require_once('./config.php');
$email=$_REQUEST["email"];
$result = DBModel::read("SELECT u.* FROM users u WHERE u.email ='". $email ."' ");

require './vendor/autoload.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();

  $mail->SMTPDebug = 1;
  $mail->isSMTP();
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPAuth = TRUE;
  $mail->Username = "ahmedmagdy2016@gmail.com";
  $mail->Password = "yxsrsiuzpaewwbhb";
  $mail->SMTPSecure = "tls";
  $mail->Port = 587;
  $mail->From = "ahmedmagdy2016@gmail.com";
  $mail->FromName = "ITI Cafeteria";
try {
   /* Set the mail sender. */
   $mail->setFrom('ahmedmagdy2016@gmail.com', 'ITI Cafeteria');

   /* Add a recipient. */
   $mail->addAddress($result[0]['email']);

   /* Set the subject. */
   $mail->Subject = 'ITI Cafeteria Password';

   /* Set the mail message body. */
//    $mail->Body = "This is your password for ITI Cafeteria :".$result[0]['password'];
    $mail->Body = "
        To Reset Your Password, Please Follow The Following Link :
        http://localhost:8080/cafeteria_system/views/resetpassword.php
    ";

   /* Finally send the mail. */
   $mail->send();
//    header("Location: /cafeteria_system/views/login.php");
}
catch (Exception $e)
{
   /* PHPMailer exception. */
   echo $e->errorMessage();
}
catch (\Exception $e)
{
   /* PHP exception (note the backslash to select the global namespace Exception class). */
   echo $e->getMessage();
}


?>