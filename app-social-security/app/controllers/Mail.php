<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller {
    public function __construct() {
        parent ::__construct();
    }

    public function index() {
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        $mail->ClearAddresses();
        $mail->ClearAttachments();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Cambia esto al servidor SMTP de tu proveedor de correo
        $mail->SMTPAuth = true;
        $mail->Username = 'winderroman3131@gmail.com'; // Tu dirección de correo electrónico
        $mail->Password = 'Amarillo2005DANI'; // Tu contraseña
        $mail->SMTPSecure = 'ssl'; // O 'ssl' si tu servidor SMTP lo requiere
        $mail->Port = 465; // Puerto SMTP

        $mail->setFrom('winderroman3131@gmail.com','Mail');
        $mail->addReplyTo('winderroman3131@gmail.com','Mail');
        $mail->addAddress('mrlibertadfinanciera09@gmail.com');
        $mail->Subject = "Hello World";
        $mail->isHTML(true);
        $message = "Hola sos un duro";
        $mail->Body = $message;
        if (!$mail->send()) {
            $status = "Email error: $mail->ErrorInfo";
        }else {
            $status = "<h1>Email enviado!</h1>";
        }

        echo $status;
    }
	
}
