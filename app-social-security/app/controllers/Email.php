<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {
    public function __construct() {
        parent ::__construct();

    }

    public function enviarEmail() {
        $this->load->library('phpmailer_lib');

        $mail = $this->phpmailer_lib->load();
        $mail->ClearAddresses();
        $mail->ClearAttachments();
        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kmma407@gmail.com'; 
        $mail->Password = 'ojljbfmwtntvwltv'; 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Port = 465; 

        $mail->setFrom('@gmail.com');
        $mail->addAddress('kmma407@gmail.com');
        $mail->Subject = "Hello World";
        $mail->isHTML(true);
        $message = "Pago exitoso";
        $mail->Body = $message;
        if (!$mail->send()) {
            $status = "Email error: $mail->ErrorInfo";
        }else {
            $status = "<h1>Email enviado!</h1>";
        }

        echo $status;
    }
	
}
