<<?php


//    $absenderName = htmlentities($_POST['besuchername']);
//    $absenderEMail = htmlentities($_POST['besuchermail']);
//    $nachricht = htmlentities($_POST['message']);

    $absenderName = 'Testname';
    $absenderEMail = 'testmail@testmail.de';
    $nachricht = 'testmassage';



    $empfaenger = 'sebastiankliem.sk@gmail.com';
    $betreff = 'Kontaktformular';
    $nachricht = "Absendername: ".$absenderName."\n
                    Absender e-Mail: ".$absenderEMail."\n
                    Nachricht: ".$nachricht;
    $header = [
        "From" => "formular@empfänger.de",
        "Reply-To" => $absenderEMail
    ];

    if(mail($empfaenger, $betreff, $nachricht, $header)) {
        echo "Mail versendet.";
    } else {
        echo "Mailversand fehlgeschlagen.";
    }
?>
