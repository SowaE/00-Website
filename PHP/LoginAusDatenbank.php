<?php
    include "Methoden.php";
    //Verbindung zur Datenbank
    $conn = VerbindungHerstellen();

    $mail = $_POST["email"];
    $passwort = $_POST["pswd"];

    if(strlen($mail) != 0) {
        if(CheckEmail($mail, $conn)) {
            $table = TabelleLesen($conn, "benutzer");
            while($row = $table->fetch_assoc()) {
                if($row["Email"] == $mail) {
                    if(password_verify($passwort, $row["Password"]) || $passwort == $row["Password"]) {
                        if($row["Email"] == "Admin") {
                            setcookie('admin', 'admin');
                        } else if($row["Email"] == "Katerer") {
                            setcookie('katerer', 'katerer');
                        }
                        echo "<script> 
                                alert('Erfolgreich angemeldet');
                                window.location.href = '../Speiseplan.html';
                            </script>";
                    } else {
                        echo "<script> 
                                alert('Falsches Passwort');
                                window.location.href = '../login.html';
                            </script>";
                    }
                }
            }
        } else {
            echo "<script> 
                    alert('Benutzer nicht gefunden');
                    window.location.href = '../login.html';
                </script>";
        }
    } else {
        echo "<script> 
                alert('Bitte alle Felder ausfüllen');
                window.location.href = '../login.html';
            </script>";
    }
?>