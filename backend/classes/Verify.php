<?php
class Verify{
    private $pdo;
    public function __constract(){
    $this->pdo=Database::instance();
    }

    public static function generateLinc(){
        return str_shuffle(substr(md5(time().mt_rand().time()), 0,25));
        
    }
    public function sendToMail($email,$messege,$subject){
        $mail=new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth=true;
        $mail->Host=M_HOST;
        $mail->Username=M_USERNAME;
        $mail->Password=M_PASSWORD;
        $mail->SMTPSecure=M_SMTPSECURE;
        $mail->Port=M_PORT;

        if(!empty($mail)){
            $mail->From="webmanywani@gmail.com";
            $mail->FromName="TWITTER";
            $mail->addReplyTo="no-reply@gmail.com";
            $mail->addAddress($email);

        if(!$mail->send()){
            return false;
        }
         else{
                return true;
            }


        }

    }

}







?>