<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

class Email
{
    // CREDÊNCIAIS PARA REALIZAR O ENVIO
    private $gmailUsername;
    private $gmailPassword;

    // REMETENTE DO EMAIL
    private $fromEmail;
    private $fromName;

    // DESTINO DA REPOSTA DO EMAIL
    private $replyEmail;
    private $replyName;

    public function login($user, $pass)
    {
        $this->gmailUsername = $user;
        $this->gmailPassword = $pass;
    }

    public function setFrom($email, $name)
    {
        $this->fromEmail = $email;
        $this->fromName  = $name;
    }

    public function setReply($email, $name)
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

        // CONFIGURAÇÕES DO SERVIDOR
        $mail->Username = $this->gmailUsername;
        $mail->Password = $this->gmailPassword;
        $mail->isSMTP();
        $mail->setLanguage('pt_br');
        $mail->SMTPDebug    = SMTP::DEBUG_OFF;
        $mail->Host         = "smtp.gmail.com";
        $mail->Port         = 587;
        $mail->CharSet      = 'UTF-8';
        $mail->SMTPSecure   = 'tls';
        $mail->SMTPAuth     = true;

        // DESTINÁRIOS
        $this->processAdresses($mail, $addresses, $hideAddresses);
        $this->precessFrom($mail);
        $this->precessReply($mail);

        // CONTEÚDO

        $mail->Subject = $title;
        $mail->msgHTML($body);
        $mail->AltBody = $alt;
        $this->processAttachment($mail, $attachments);

        // ENVIO
        if ($mail->send()) {
            $onSuccess($addresses);
        } else {
            $onFailure($mail->ErrorInfo);
        }
    }

    private function processAdresses($mailerInstance, $addresses, $hideAddresses = true)
    {
        $addresses = is_array($addresses) ? $addresses : [$addresses];
        foreach ($addresses as $address) {
            if ($hideAddresses) $mailerInstance->addBCC($address);
            $mailerInstance->addAddress($address);
        }
    }

    private function precessFrom($mailerInstance)
    {
        if (empty($this->fromEmail)) {
            return;
        } else {
            if (empty($this->fromName)) {
                $mailerInstance->setFrom($this->fromEmail);
            } else {
                $mailerInstance->setFrom($this->fromEmail, $this->fromName);
            }
        }
    }

    private function precessReply($mailerInstance)
    {
        if (empty($this->replyEmail)) {
            return;
        } else {
            if (empty($this->replyName)) {
                $mailerInstance->addReplyTo($this->replyEmail);
            } else {
                $mailerInstance->addReplyTo($this->replyEmail, $this->replyName);
            }
        }
    }

    private function processAttachment($mailerInstance, $file, $isGlobal = true)
    {
        if ($isGlobal) {
            $fileName = $file['name'];
        } else {
            $fileName = $file;
        }

        $ext = PHPMailer::mb_pathinfo($fileName, PATHINFO_EXTENSION);
        $finalTempPath = tempnam(sys_get_temp_dir(), hash('sha256', $file['name'])) . '.' . $ext;
        move_uploaded_file($file['tmp_name'], $finalTempPath);

        $mailerInstance->addAttachment($finalTempPath, $fileName);
    }
}
