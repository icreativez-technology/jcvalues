<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
// Create an instance of PHPMailer class 
$mail = new PHPMailer();
// SMTP configuration
// $mail->SMTPDebug = 4;
$mail->isSMTP();
$mail->Host     = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'jcdefaultmail@gmail.com';
$mail->Password = 'tuclyfagmwmloccz'; //Please give app password of gmail
$mail->SMTPSecure = 'tls';
$mail->Port     = 587;
$mail->setFrom('jcdefaultmail@gmail.com', 'JC Valves');
$app_url = "http://13.235.239.224/";