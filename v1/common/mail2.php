<?php
    require_once('PHPMailer_v5.1/class.phpmailer.php'); //library added in download source.
   /* $msg  = 'Notification TOTAL WEECARD';
    $subj = 'test mail message';
    $to   = 'basopro1@gmail.com';
    $from = 'weecard2016@gmail.com';
    $name = 'My Name';

   echo smtpmailer2($to,$from, $name ,$subj, $msg);*/
    
    function smtpmailer2($to, $from = 'weecard2016@gmail.com', $from_name = 'TOTAL WEECARD', $subject, $body, $is_gmail = true)
    {
        global $error;
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; 
        if($is_gmail)
        {
            $mail->SMTPSecure = 'ssl'; 
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;  
            $mail->Username = 'weecard2016@gmail.com';  
            $mail->Password = 'totalinnovation2016';   
        }
        else
        {
            $mail->Host = 'smtp.mail.google.com';
            $mail->Username = 'weecard2016@gmail.com';  
            $mail->Password = 'totalinnovation2016';   
        }
        $mail->IsHTML(true);
        $mail->From="weecard2016@gmail.com";
        $mail->FromName="TOTAL WEECARD";
        $mail->Sender=$from; // indicates ReturnPath header
        $mail->AddReplyTo($from, $from_name); // indicates ReplyTo headers
       // $mail->AddCC('cc@site.com.com', 'CC: to site.com');
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        if(!$mail->Send())
        {
            $error = 'Mail error: '.$mail->ErrorInfo;
            return true;
        }
        else
        {
            $error = 'Message sent!';
            return false;
        }
    }

    
?>