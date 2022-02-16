<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Replace this with your own email address
// $to = 'minilog69@gmail.com';

function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}

if($_POST) {

   require 'vendor/autoload.php';

   $name = trim(stripslashes($_POST['name']));
   $phone = trim(stripslashes($_POST['phone']));
   $email = trim(stripslashes($_POST['email']));
   $subject = "Contact Form Submission";
   $contact_message = trim(stripslashes($_POST['message']));

   

  if ($phone == '') { $phone = "N/A"; }

   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
 	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

     //body
        // Set Message
        $body = "";
        $body .= "Email from: " . $name . "<br />";
        $body .= "Phone Number: " . $phone . "<br />";
         $body .= "Email address: " . $email . "<br />";
        $body .= "Message: <br />";
        $body .= nl2br($contact_message);
        $body .= "<br /> ----- <br /> This email was sent from your site " . url() . " contact form. <br />";
     
   $mail = new PHPMailer(true);

   try {
       //Server settings
      //  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
       $mail->isSMTP();                                            //Send using SMTP
       $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
       $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
       $mail->Username   = 'minilog69@gmail.com';                     //SMTP username
       $mail->Password   = 'mwznnivvkznuoryo';                               //SMTP password
       $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
       $mail->Port       = 587;                             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
   
         //Sender
        $mail->setFrom($email, $name);

       
       //Recipients
       $mail->addAddress('tutors@ieltsinn.com', 'Mailer');     //Add a recipient
   
     
       //Content
       $mail->isHTML(true);                                  //Set email format to HTML
       $mail->Subject = $subject;
       $mail->Body    = $body;
       $mail->AltBody = strip_tags($body);
   
       $mail->send();
       echo 'Message has been sent';
   } catch (Exception $e) {
       echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
   }

}
