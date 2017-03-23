<?php
    require_once('PHPMailer_v5.1/class.phpmailer.php'); //library added in download source.
    /*$msg  = 'Notification TOTAL WEECARD';
    $subj = 'test mail message';
    $to   = 'basopro1@gmail.com';
    $from = 'bravaapps@gmail.com';
    $name = 'My Name';*/

  // echo smtpmailer($to,$from, $name ,$subj, $msg);
    
    function smtpmailer($to, $from = 'basopro1@gmail.com', $from_name = 'TOTAL WEECARD', $subject, $body, $is_gmail = true)
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
            $mail->Username = 'basopro1@gmail.com';  
            $mail->Password = 'stayprogodo';   
        }
        else
        {
            $mail->Host = 'smtp.mail.google.com';
            $mail->Username = 'basopro1@gmail.com';  
            $mail->Password = 'stayprogodo';   
        }
        $mail->IsHTML(true);
        $mail->From="basopro1@gmail.com";
        $mail->FromName="STARTUP";
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