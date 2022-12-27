<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

class Email
{
    // CREDÊNCIAIS PARA REALIZAR O ENVIO
    private $gmailUsername;
    private $gmailPassword;

    // REMETENTE DO EMAIL
    private $fromEmail = '';
    private $fromName  = '';

    // DESTINO DA REPOSTA DO EMAIL
    private $replyEmail = '';
    private $replyName  = '';

    public function login($user, $pass)
    {
        $this->gmailUsername = $user;
        $this->gmailPassword = $pass;
    }

    public function setFrom($email, $name = '')
    {
        $this->fromEmail = $email;
        $this->fromName  = $name;
    }

    public function setReply($email, $name = '')
    {
        $this->replyEmail = $email;
        $this->replyName  = $name;
    }

    public function send(
        $addresses,
        $title = '',
        $body,
        $alt = '',
        $hideAddresses = true,
        $attachments = null,
        $onSuccess,
        $onFailure
    ) {
        $mail = new PHPMailer;

        // CONFIGURAÇÕES
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->setLanguage('pt_br');

        // INFORMAÇÕES
        $mail->Username = $this->gmailUsername;
        $mail->Password = $this->gmailPassword;
        $mail->setFrom($this->fromEmail, $this->fromName);
        $mail->addReplyTo($this->replyEmail, $this->replyName);

        // MENSAGEM
        $addresses = is_array($addresses) ? $addresses : [$addresses];
        foreach ($addresses as $address) {
            if ($hideAddresses) $mail->addBCC($address);
            $mail->addAddress($address);
        }

        $mail->Subject = $title;
        $mail->msgHTML($body);
        $mail->AltBody = $alt;

        $attachments = is_array($attachments) ? $attachments : [$attachments];
        foreach ($attachments as $attachment) {
            $mail->addAttachment($attachment);
        }

        // ENVIO
        if (!$mail->send()) {
            $onFailure($mail->ErrorInfo);
        } else {
            $onSuccess($addresses);
        }
    }
}
