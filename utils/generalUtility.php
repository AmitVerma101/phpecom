<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include('vendor/Autoload.php');
    require_once('config/env.php');
    $expiry_time = 1;
    function generate_activation_code(): string
    {
        return bin2hex(random_bytes(16));
    }
    function generate_activation_expiry(){
        $original_date = date("Y-m-d"); // Your original date
         // Number of days to add
        $new_date = date("Y-m-d", strtotime($original_date . " + 1 days"))." ".date('h:i:s');

        
        return $new_date; 
    }
    function sendMail($email,$message,$subject){
        $mail = new PHPMailer(); 
        $mail->IsSMTP(); 
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = 'tls'; 
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587; 
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        //$mail->SMTPDebug = 2; 
        $mail->Username = 'amitver2000@gmail.com';
        $mail->Password = "yejeikzmrqfrcxcw";
        $mail->SetFrom("amitver2000@gmail.com");
        $mail->Subject = $subject;
        $mail->Body =$message;
        $mail->AddAddress($email);
        $mail->SMTPOptions=array('ssl'=>array(
            'verify_peer'=>false,
            'verify_peer_name'=>false,
            'allow_self_signed'=>false
        ));
        if(!$mail->Send()){
            return false;
        }else{
            return true;
        }
    

    }

    function sendMailWithAttatchment($email,$message,$subject,$path,$filename){
        $mail = new PHPMailer(); 
        $mail->IsSMTP(); 
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = 'tls'; 
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587; 
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        //$mail->SMTPDebug = 2; 
        $mail->addAttachment("$path",$filename);
        $mail->Username = 'amitver2000@gmail.com';
        $mail->Password = "yejeikzmrqfrcxcw";
        $mail->SetFrom("amitver2000@gmail.com");
        $mail->Subject = $subject;
        $mail->Body =$message;
        $mail->AddAddress($email);
        $mail->SMTPOptions=array('ssl'=>array(
            'verify_peer'=>false,
            'verify_peer_name'=>false,
            'allow_self_signed'=>false
        ));
        if(!$mail->Send()){
            return false;
        }else{
            return true;
        }
    }
?>