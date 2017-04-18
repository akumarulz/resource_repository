
<?php
//code to send an email to subscriber
// http://www.sitepoint.com/sending-emails-php-phpmailer/

require 'PHPMailer-master/PHPMailerAutoload.php';
function sendEmail($mailTo){
	
			$recipName = $mailTo['firstname'] .' '. $mailTo['surname'];
			$recipEmail = $mailTo['email'];
			$messageSubject = $mailTo['subject'];
			$message = $mailTo['message'];
			
			$mail = new PHPMailer();
			
			$mail->isSMTP(); 
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'darday1984@gmail.com';                   
			$mail->Password = 'Raven1984';
			$mail->From = 'darday1984@gmail.com';			
			$mail->SMTPSecure = 'tls';
			$mail->isHTML(true);
			$mail->Port = 587;
			$mail->setFrom('darday1984@gmail.com', 'Michael Taylor');
			$mail->addAddress($recipEmail, $recipName);
			$mail->WordWrap = 50; 
			$mail->Subject = $messageSubject;
			$mail->Body    = $message;
			
			
			if(!$mail->send()) {
   
				echo $mail->ErrorInfo;
				exit;
				}
}
			
?>