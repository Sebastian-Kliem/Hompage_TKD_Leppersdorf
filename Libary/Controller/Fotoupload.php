<?php

namespace Controller;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Fotoupload extends Base_Controller
{
    public function homeAction($parameter)
    {
        // Weiterleitung zur trainingszeitenAction
        $this->uploadAction($parameter);
    }

    public function uploadAction($parameter)
    {
        session_start();
        if (!isset($_SESSION["pictureupload_allowed"])) {
            $_SESSION["pictureupload_allowed"] = false;
        }

        if (file_exists($_SERVER['DOCUMENT_ROOT']."/config.php")) {
            $configs = include($_SERVER['DOCUMENT_ROOT'] . "/config.php");
        } elseif (file_exists($_SERVER['DOCUMENT_ROOT']."config.php")) {
            $configs = include($_SERVER['DOCUMENT_ROOT'] . "config.php");
        }

        $upload_status = "";
        if ($this->isPost()) {
            if (isset($_POST['submit_upload_login'])) {
                if (isset($_POST["password"])) {
                    if ($_POST["password"] == "TKDleppe-2023") {
                        $_SESSION["pictureupload_allowed"] = true;
                    }
                }
            }


            if (isset($_POST['submit_upload'])) {



                $name = preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['name']); // Entfernt alle nicht-alphanumerischen Zeichen
                $event_name = preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['eventname']); // Entfernt alle nicht-alphanumerischen Zeichen

                $target_directory = "picture_uploads/" . $name . '_' . $event_name . '/';

                if (!file_exists($target_directory)) {
                    if (!mkdir($target_directory, 0777, true)) {
                        die('Fehler beim Erstellen der Verzeichnisse...');
                    }
                }

                if (isset($_FILES['files'])) {
                    $allowed_formats = ['image/jpeg', 'image/png', 'image/gif'];

                    $erfolgreicheUploads = 0;
                    $fehlgeschlageneUploads = [];
                    foreach ($_FILES['files']['name'] as $index => $filename) {
                        $filetype = $_FILES['files']['type'][$index];

                        if (!in_array($filetype, $allowed_formats)) {
                            continue;
                        }
                        if (!$_FILES['files']['error'][$index] == UPLOAD_ERR_OK) {
                            continue;
                        }

                        if (!in_array($filetype, $allowed_formats)) {
                            $fehlgeschlageneUploads[] = $filename . " (falscher Dateityp)";
                            continue;
                        }
                        if ($_FILES['files']['error'][$index] !== UPLOAD_ERR_OK) {
                            $fehlgeschlageneUploads[] = $filename . " (Upload-Fehler)";
                            continue;
                        }

                        $tmp_name = $_FILES['files']['tmp_name'][$index];

                        $upload_filename = $target_directory . basename($filename);

                        if (move_uploaded_file($tmp_name, $upload_filename)) {
                            $erfolgreicheUploads++;
                        } else {
                            $fehlgeschlageneUploads[] = $filename . " (Fehler beim Verschieben der Datei)";
                        }

                        if ($erfolgreicheUploads > 0 && count($fehlgeschlageneUploads) === 0) {
                            $upload_status = strval($erfolgreicheUploads) . " Dateien wurden erfolgreich hochgeladen.";
                        } elseif ($erfolgreicheUploads > 0) {
                            $upload_status = $erfolgreicheUploads . " Datei(en) erfolgreich hochgeladen. Fehlgeschlagen: " . implode(", ", $fehlgeschlageneUploads);
                        } else {
                            $upload_status = "Keine Dateien hochgeladen. Fehlgeschlagen: " . implode(", ", $fehlgeschlageneUploads);
                        }
                    }
                }

            }

        }
        if ($_SESSION["pictureupload_allowed"]) {
            echo $this->renderTemplate('fotoupload.phtml', ["upload_status" => $upload_status]);
        } else {
            echo $this->renderTemplate('fotoupload_login.phtml', []);
        }

    }
}