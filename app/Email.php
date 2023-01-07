<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require './app/PHPMailer/src/Exception.php';
require './app/PHPMailer/src/PHPMailer.php';
require './app/PHPMailer/src/SMTP.php';

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
        $addresses = $this->asArray($addresses);
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
            $allFiles       = $this->asArray($file['name']);
            $allTempFiles   = $this->asArray($file['tmp_name']);
        } else {
            $allFiles       = $this->asArray($file);
        }

        for ($i = 0; $i < count($allFiles); $i++) {
            $extension      = PHPMailer::mb_pathinfo($allFiles[$i], PATHINFO_EXTENSION);
            $hashValue      = hash('sha256', $allFiles[$i]);
            $finalTempPath  = tempnam(sys_get_temp_dir(), $hashValue) . ".$extension";

            move_uploaded_file($allTempFiles[$i], $finalTempPath);
            
            $mailerInstance->addAttachment($finalTempPath, $allFiles[$i]);
        }
    }

    private function asArray($variable)
    {
        $array = is_array($variable) ? $variable : [$variable];
        return $array;
    }
}
