<?php
    include "Methoden.php";
    // Verbindung mit Datenbanken herstellen
    $conn = VerbindungHerstellen();

    // Daten auf Folständigkeit prüfen
    $mail = $_POST["email"];
    $vName = $_POST["vorname"];
    $nName = $_POST["nachname"];
    $passwort = $_POST["pswd"];
    $wdhPasswort = $_POST["wdhPswd"];
    $klasse = $_POST["klasse"];
    
    // Prüfen ob alle Felder einen Wert enthalten
    if(strlen(NoMoreFalschEingabe($mail)) != 0 && strlen(NoMoreFalschEingabe($passwort)) != 0 && strlen(NoMoreFalschEingabe($wdhPasswort)) != 0 && strlen(NoMoreFalschEingabe($vName)) != 0 && strlen(NoMoreFalschEingabe($nName)) != 0) {
        if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) 
        {
            echo "<script> 
                    alert('Invalides Email Format');
                    window.location.href = '../Registration.php';
                 </script>";
        }
        else {
            // Passwörter auf Gleichheit prüfen
            if($passwort != $wdhPasswort) {
                echo "<script> 
                        alert('Passwörter stimmen nicht über ein');
                        window.location.href = '../Registration.php';
                    </script>";
            }
            else {
                // Prüfen ob Benutzer bereits vorhanden ist
                if(CheckEmail($mail, $conn)) {
                    echo "<script> 
                            alert('Benutzer bereits vorhanden');
                            window.location.href = '../Registration.php';
                        </script>";
                }
                else {
                    // Neuen Benutzer anlegen
                    NeuenBenutzerAnlegen($mail, $vName, $nName, $passwort, $klasse, $conn);
                    echo "<script> 
                            window.location.href = '../SpeisePlan.html';
                        </script>";
                }
            }
        }
    }
    else {
        echo "<script> 
                alert('Alle Felder ausfüllen');
                window.location.href = '../Registration.php';
            </script>";
    }

    mysqli_close($conn);
?>