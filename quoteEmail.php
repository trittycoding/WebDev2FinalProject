<?php
//Email: designbythegoat@gmail.com
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\STMP;
use \PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer;
$mail->isSMTP();                            // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';              // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                     // Enable SMTP authentication
$mail->Username = 'designbythegoat@gmail.com'; // your email id
$mail->Password = 'pWi7nGNakEbkqRh'; // your password
$mail->SMTPSecure = 'tls';                  
$mail->Port = 587;     //587 is used for Outgoing Mail (SMTP) Server.
$mail->setFrom('designbythegoat@gmail.com', 'Customer Support');
$mail->addAddress($_POST['email']);   // Add a recipient
$mail->isHTML(true);  // Set email format to HTML

$bodyContent = "<h1>Greetings {$_POST['name']}</h1>";
$bodyContent .= "<p>Thank you for your interest in our company, we have forwarded your email to our support team and will be in contact with you as soon as possible.</p>
                RE: Quote {$_POST['text']}";
$mail->Subject = 'Quote From DesignByTheGoat';
$mail->Body    = $bodyContent;
if(!$mail->send()) {
  echo 'Message was not sent.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
  header('Location: index.php');
}

?>