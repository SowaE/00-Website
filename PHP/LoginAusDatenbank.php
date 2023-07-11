<?php
    include "Methoden.php";
    //Verbindung zur Datenbank
    $conn = VerbindungHerstellen();

    $mail = $_POST["mail"];
    $passwort = $_POST["pswd"];

    if(!isset($mail) && !isset($passwort)) {
        if(!CheckEmail($user_email)) {
            echo "<script> 
                    alert('Benutzer nicht gefunden');
                    window.location.href = '../login.html';
                </script>";
        } else {
            $table = TabelleLesen($conn, "benutzer");
            while($row = $table->fetch_assoc()) {
                if($row["Email"] == $mail) {
                    if($row["Password"] != $passwort) {
                        echo "<script> 
                                alert('Falsches Passwort');
                                window.location.href = '../login.html';
                            </script>";
                    } else {
                        echo "<script> 
                                alert('Erfolgreich angemeldet');
                                window.location.href = '../Speiseplan.html';
                            </script>";
                    }
                }
            }
        }
    } else {
        echo "<script> 
                alert('Bitte alle Felder ausfüllen');
                window.location.href = '../login.html';
            </script>";
    }
?>