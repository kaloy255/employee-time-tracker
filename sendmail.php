<?php
 // generate verification token
 $verificationCode = strtoupper(substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6));
  // generate reset password token
 $reset_code = strtoupper(substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6));


 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;
 
 //Load Composer's autoloader
 require 'vendor/autoload.php';
 // function mail sender
 function sendmail_verify($email,$fullname, $verificationCode){
     //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
 
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lifehack825@gmail.com';
        $mail->Password = 'yikb xtag usen ibgc'; // Use App Password here
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('timeisblue@gmail.com','TimeisBlue');
        $mail->addAddress($email, $fullname);     //Add a recipient
        $mail->addReplyTo('carlodatugarcia@gmail.con', 'Developer');
    
    
        // Attachments
    
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Verify Your Email Address';
        
        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
        <title>Verify Your Email</title>
        </head>
        <body style="font-family: Arial, sans-serif; background-color: #1a1c23; color: #d1d5db; margin: 0; padding: 0;">
        <div style="max-width: 600px; margin: auto; background-color: #252835; padding: 24px; border-radius: 8px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);">
            <div style="text-align: center; margin-bottom: 24px;">
            <img src="https://yourdomain.com/path-to-logo/logo.svg" alt="TimeisBlue Logo" style="width: 120px; margin-bottom: 16px;"> <!-- Replace with the public URL -->
            <p style="font-size: 24px; font-weight: bold; color: #e0f2fe; margin: 0;">Verify Your Email</p>
            </div>
            <div style="font-size: 16px; color: #cbd5e1; line-height: 1.6; margin-top: 16px;">
            <p>Hi,'.$fullname.'</p>
            <p>To finish setting up your account, please verify your email by using the code below or by clicking the "Verify Email" button:</p>
            <span style="display: block; font-size: 28px; font-weight: bold; color: #38bdf8; text-align: center; background-color: #0e7490; padding: 16px; border-radius: 8px; margin: 20px 0;">'.$verificationCode.'</span>
            <p style="text-align: center; margin-top: 20px;">
                <a href="http://localhost/employee-time-tracker/verify-email.php?token='.md5($verificationCode).'" style="display: inline-block; padding: 12px 24px; font-size: 18px; font-weight: bold; color: #ffffff; background-color: #38bdf8; border-radius: 8px; text-decoration: none;">Verify Email</a>
            </p>
            <p>If you did not sign up for this account, you can safely ignore this email.</p>
            </div>
            <div style="font-size: 14px; color: #6b7280; text-align: center; margin-top: 24px;">
            <p>Need help? <a href="https://support.timeisblue.com" target="_blank" style="color: #38bdf8; text-decoration: none;">Contact Support</a></p>
            </div>
        </div>
        </body>
        </html>
        ';
        
        $mail->AltBody = 'Thank you for registering! Please verify your email address using the code: ' . strtoupper($verificationCode) . ' If you didn\'t request this, you can safely ignore this email.';
        
    
        $mail->send();
       
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  
 }



//  function send reset password token
 function sendmail_reset_password($email,$fullname, $reset_code){
    //Create an instance; passing `true` enables exceptions
   $mail = new PHPMailer(true);

   try {
       //Server settings
       $mail->isSMTP();
       $mail->Host = 'smtp.gmail.com';
       $mail->SMTPAuth = true;
       $mail->Username = 'lifehack825@gmail.com';
       $mail->Password = 'yikb xtag usen ibgc'; // Use App Password here
       $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
       $mail->Port = 587;  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
   
       //Recipients
       $mail->setFrom('timeisblue@gmail.com','TimeisBlue');
       $mail->addAddress($email, $fullname);     //Add a recipient
       $mail->addReplyTo('carlodatugarcia@gmail.con', 'Developer');
   
   
       // Attachments
   
       //Content
       $mail->isHTML(true);                                  // Set email format to HTML
       $mail->Subject = 'Reset  Your Password';
       
       $mail->Body = '
      <!DOCTYPE html>
        <html>
        <head>
        <title>Reset Your Password</title>
        </head>
        <body style="font-family: Arial, sans-serif; background-color: #1a1c23; color: #d1d5db; margin: 0; padding: 0;">
        <div style="max-width: 600px; margin: auto; background-color: #252835; padding: 24px; border-radius: 8px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);">
            <div style="text-align: center; margin-bottom: 24px;">
            <img src="assets/logo.svg" alt="TimeisBlue Logo" style="width: 120px; margin-bottom: 16px;"> <!-- Replace with your logo URL -->
            <p style="font-size: 24px; font-weight: bold; color: #e0f2fe; margin: 0;">Reset Your Password</p>
            </div>
            <div style="font-size: 16px; color: #cbd5e1; line-height: 1.6; margin-top: 16px;">
            <p>Hi,'.$fullname.'</p>
            <p>We received a request to reset your password. Use the code below to proceed with resetting your password:</p>
            <span style="display: block; font-size: 28px; font-weight: bold; color: #38bdf8; text-align: center; background-color: #0e7490; padding: 16px; border-radius: 8px; margin: 20px 0;">'.$reset_code.'</span>
            <p>If you did not request this change, please ignore this email or contact our support team.</p>
            </div>
            <div style="font-size: 14px; color: #6b7280; text-align: center; margin-top: 24px;">
            <p>Need help? <a href="https://support.timeisblue.com" target="_blank" style="color: #38bdf8; text-decoration: none;">Contact Support</a></p>
            </div>
        </div>
        </body>
        </html>
       ';
       
       $mail->AltBody = 'Thank you for registering! Please verify your email address using the code: ' . strtoupper($reset_code) . ' If you didn\'t request this, you can safely ignore this email.';
       
   
       $mail->send();
       echo 'Message has been sent';
   } catch (Exception $e) {
       echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
   }
 
}

