<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//required files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host ='smtp.gmail.com';  //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = 'natda002@gmail.com';                 //SMTP username
    $mail->Password = 'cfta ackg mfal goor';                           //SMTP password
    $mail->SMTPSecure = 'ssl';                            //Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    //TCP port to connect to
                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('natda002@gmail.com', 'fact');
    $mail->addAddress('natdanai@aoth.in.th' , 'Natdanai');     //Add a recipient
       //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Test Send Link Project';
    $mail->Body    = 'http://localhost/PCB_NG/LoginPHP/';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}