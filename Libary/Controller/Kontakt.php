<?php

namespace Controller;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Kontakt extends Base_Controller
{
    public function kontaktAction($parameter)
    {
        session_start();

        $sendMailParameter = [];
        $sendMailRequest = false;
        $sendMailResponse = false;

        if (file_exists($_SERVER['DOCUMENT_ROOT']."/config.php")) {
            $configs = include($_SERVER['DOCUMENT_ROOT'] . "/config.php");
        } elseif (file_exists($_SERVER['DOCUMENT_ROOT']."config.php")) {
            $configs = include($_SERVER['DOCUMENT_ROOT'] . "config.php");
        }

        if (isset($parameter["sendMailResponse"])) {
            $sendMailParameter = $parameter;
        }

        if ($this->isPost()) {

            require_once "vendor/autoload.php";

            $messageWithHTML = "Name des Absenders: " . $_POST['name'] . "<br>
                                E-Mail des Absenders: " . $_POST['email'] . "<br><hr><br>" . $_POST['message'];

            $messageWithOutHTML = "Name des Absenders: " . $_POST['name'] . "
                            E-Mail des Absenders: " . $_POST['email'] . "
                            Nachricht:  " . $_POST['message'];

            $mail = new PHPMailer();
//            $mail->SMTPDebug = SMTP::DEBUG_SERVER;

            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->CharSet   = 'UTF-8';
            $mail->Encoding  = 'base64';

            $mail->Host       = $configs['host'];
            $mail->Port       = $configs['port'];

            $mail->Username   = $configs['username'];
            $mail->Password   = $configs['password'];

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->setFrom($configs['emailFrom']);
            $mail->addAddress($configs['emailTo']);

            $mail->addReplyTo($configs['reply']);

            $mail->isHTML(true);
            $mail->Subject = 'neue Anfrage per Kontaktformular von Website';
            $mail->Body    = $messageWithHTML;
            $mail->AltBody = $messageWithOutHTML;

            try {
                $sendMailResponse = $mail->send();
            } catch (Exception $exception) {
                //var_dump($exception);
            }

            if ($sendMailResponse) {
                $header = "true";
            } else {
                $header = "false";
                $_SESSION['contactform'] = [
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'massage' => $_POST['message']
                ];
            }

            header('Location: '. \App::getBaseURL()."kontakt/kontakt/sendMailResponse/". $header);
        }

        echo $this->renderTemplae('kontakt.phtml', ['sendMailParameter' => $sendMailParameter]);
    }
}