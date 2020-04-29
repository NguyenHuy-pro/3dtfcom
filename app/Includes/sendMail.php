<?php

/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 12/16/2016
 * Time: 12:00 PM
 */
class Mail3dtf
{
    public function checkExist($email)
    {
        $fromEmail = '3dtfcom.ser@gmail.com';
        $mailValidate = new  SMTP_Validate_Email($email, $fromEmail);
        $smtp_results = $mailValidate->validate();
        if($smtp_results[$email]){
            return true;
        }else{
            return false;
        }
    }

    public function sendFromGmail($subject, $toEmail, $content)
    {
//        $mail = new PHPMailer();
//        /*=====================================
//         * THIET LAP THONG TIN GUI MAIL
//         *=====================================*/
//        $mail->IsSMTP();
//        $mail->Host = "smtp.gmail.com";
//        $mail->Port = 465;
//        //$mail->Port = 587;
//        $mail->SMTPDebug = 1;
//        $mail->SMTPAuth = true;
//        $mail->SMTPSecure = 'tls';
//        ///$mail->SMTPSecure = 'ssl';
//        $mail->Username = "3dtfcom.ser@gmail.com";
//        ///$mail->Password = "3dtfproject3dtf";
//        $mail->Password = "3dtfser3dtf";
//        //Thiet lap thong tin nguoi gui va email nguoi gui
//        $mail->SetFrom('3dtfcom.ser@gmail.com', 'SERVICE FROM 3DTF.COM');
//
//        $mail->AddAddress($toEmail, "3DTF.COM Group");
//        //$mail->AddReplyTo("3dtfcom.project@gmail.com","Administrator");
//        /*=====================================
//         * THIET LAP NOI DUNG EMAIL
//         *=====================================*/
//        $mail->Subject = $subject;
//        $mail->CharSet = "utf-8";
//        $mail->Body = $content;
//        return $mail->Send();
        return $this->sendEmailInfo3D($subject,$toEmail,$content);
    }
    public function sendEmailInfo3D($subject,$toEmail,$content){
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "mail.3dtf.com";
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        //$mail->SMTPSecure = "tls";
        $mail->Username = "info@3dtf.com";
        $mail->Password = "info3dtf2013";
        $mail->Port = 25;
        $mail->SetFrom("info@3dtf.com",'SERVICE FROM 3DTF.COM');
        $mail->AddAddress($toEmail,"3DTF.COM Group");
        $mail->AddReplyTo("info@3dtf.com","Administrator");
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->CharSet = "utf-8";
        $mail->Body = $content;
        return $mail->Send();
    }
    # lay dia chi email
    public function getServiceMail(){
        return 'info@3dtf.com';
    }
}