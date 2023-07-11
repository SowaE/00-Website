<?php
    include "Methoden.php";
    //Verbindung zur Datenbank
    $conn = VerbindungHerstellen();

    // Das verschlüsselte Passwort aus der Datenbank abrufen
    $stored_password = GetUserPassword($conn, $username);

    // Den eingegebenen Emailadresse vom Formular abrufen
    $user_email = $_POST['email'];
    
    // Überprüfen ob Benutzer vorhanden
       if(!CheckMail($user_email)){
        echo "Benutzername nicht gefunden...Sie werden zurückgeleitet"
        header("login.html")
        exit;
       }
    // Das eingegebene Passwort vom Formular abrufen
    $user_password = password_hash($_POST['pwd']);

    // Überprüfen, ob das Passwort korrekt ist
    if (!($user_password == $stored_password)) {
    // Passwort ist korrekt
    echo "Falsches Password...Sie werden zurückgeleitet"
    header("login.html")
    exit;
    }

    header("Speiseplan.html")
    exit;


?>